<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use App\Models\TaskApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkerProfile;
use App\Models\Notification;
use App\Models\Progression;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;

class JobController extends Controller
{
    // List All Jobs 
    public function index()
    {

        $jobs = Task::all();
        return view('General.jobs', compact('jobs'));
    }

    public function indexWorker()
    {
        $worker = Auth::user();
        $workerProfile = $worker->workerProfile;
        return view('worker.dashboardWorker', compact('workerProfile'));
    }


    // Tampilan add newjob
    public function addJobView()
    {
        if (Auth::user()->role == 'client') {
            return view('Client.addJobNew');
        } else {
            return view('admin.dashboardAdmin');
        }
    }


    // Create job Client
    public function createJobClient(Request $request)
    {
        $request->validate([
            'job_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240', // max 2MB
        ]);


        // Handle file upload jika ada
        $path = null;
        if ($request->hasFile('job_file')) {
            $path = $request->file('job_file')->store('task_files', 'public');
        }



        $task = Task::create([
            'client_id' => Auth::id(),
            'profile_id' => null, // default null, nanti diassign saat ada worker apply
            'title' => $request->title,
            'description' => $request->description,
            'qualification' => $request->qualification,
            'provisions' => $request->rules,
            'start_date' => $request->start_date,
            'deadline' => $request->deadline,
            'deadline_promotion' => $request->deadline_promotion,
            'price' => $request->price,
            'status' => 'open',
            'revisions' => $request->revisions,
            'kategory' => json_encode($request->kategoriWorker),
            'job_file' => $path,
        ]);
        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
    }


    // Tampilan add newjob
    public function updateJobView($id)
    {
        $job = Task::findOrFail($id);
        return view('Client.updateJob', compact('job'));
    }

    public function updateJobClient(Request $request, $id)
    {
        $request->validate([
            'job_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240', // max 10MB
        ]);

        // Cari task berdasarkan ID, atau gagal 404 jika tidak ada
        $task = Task::findOrFail($id);

        $oldFilePath = $task->job_file;
        $newPath = $oldFilePath;

        if ($request->hasFile('job_file')) {
            $newPath = $request->file('job_file')->store('task_files', 'public');

            if ($oldFilePath && \Storage::disk('public')->exists($oldFilePath)) {
                \Storage::disk('public')->delete($oldFilePath);
                \Log::info("File lama milik task ID {$task->id} telah dihapus: {$oldFilePath}");
            }
        }

        $task->update([
            'title' => $request->title ?? $task->title,
            'description' => $request->description ?? $task->description,
            'qualification' => $request->qualification ?? $task->qualification,
            'provisions' => $request->rules ?? $task->provisions,
            'start_date' => $request->start_date ?? $task->start_date,
            'deadline' => $request->deadline ?? $task->deadline,
            'deadline_promotion' => $request->deadline_promotion ?? $task->deadline_promotion,
            'price' => $request->price ?? $task->price,
            'revisions' => $request->revisions ?? $task->revisions,
            'kategory' => $request->kategoriWorker ? json_encode($request->kategoriWorker) : $task->kategory,
            'job_file' => $newPath,
        ]);

        return redirect()->route('jobs.index')->with('success-edit', "Job telah diperbarui!.");
    }



    public function getJobData()
    {
        $jobs = task::selectRaw('count(*) as count, category')
            ->groupBy('category')
            ->get();

        return response()->json($jobs);
    }
    public function show($id)
    {
        // Ambil job berdasarkan ID dari URL
        $job = task::with('user')->findOrFail($id); // Ambil juga relasi user jika ada

        // Ambil semua pelamar
        $applicants = TaskApplication::with([
            'worker.user',
            'worker.certifications.images',
            'worker.portfolios.images',
        ])
            ->where('task_id', $id)
            ->get();

        // Dapatkan profile_id worker yang sedang login
        $profileId = WorkerProfile::where('user_id', Auth::id())->value('id');

        // Cek apakah user ini sudah melamar task tersebut
        $hasApplied = TaskApplication::where('task_id', $id)
            ->where('profile_id', $profileId)
            ->exists();

        // Kirim ke view, tambahkan variabel $hasApplied
        return view('General.showJobsDetail', compact('job', 'applicants', 'hasApplied'));
    }
    public function myJobs()
    {
        $task = Task::where('client_id', Auth::id())->get();
        return view('client.jobs.myJobClient', compact('task'));
    }

    public function myJobsWorker()
    {
        $user = Auth::user();
        $workerProfile = $user->workerProfile;
        // Ambil TaskApplication yang berhubungan dengan workerProfile
        $taskApplied = TaskApplication::with(['task', 'profile'])
            ->where('profile_id', $workerProfile->id)
            ->get(); // Semua lamaran yang diterima oleh workerProfile

        // Ambil Task yang berhubungan dengan workerProfile (task yang dikerjakan oleh worker)
        $task = Task::with('worker')
            ->where('profile_id', $workerProfile->id) // Asumsi profile_id di task adalah id dari workerProfile
            ->get();
        return view('Worker.Jobs.myJobWorker', compact('taskApplied', 'task'));
    }



    public function manage($id, Request $request)
    {
        $task = Task::with('user')->findOrFail($id);

        // Filter
        $sortBy = $request->get('sort', 'bidPrice'); // default: harga
        $sortDir = $request->get('dir', 'asc'); // default: naik
        $allowedSorts = ['bidPrice', 'experience']; // experience berasal dari relasi
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'bidPrice';
        }
        $applicants = TaskApplication::with([
            'worker.user',
            'worker.certifications.images',
            'worker.portfolios.images',
        ])
            ->where('task_id', $id)
            ->get()
            ->sortBy(function ($applicant) use ($sortBy) {
                if ($sortBy === 'experience') {
                    return $applicant->worker->pengalaman_kerja ?? 0;
                }
                return $applicant->{$sortBy} ?? 0;
            }, SORT_REGULAR, $request->get('dir') === 'desc')
            ->values(); // reset index

        return view('client.jobs.manage', compact('task', 'applicants'));
    }


    public function manageWorker($id)
    {
        $task = Task::with('user')->findOrFail($id);

        // Cari lamaran user ini (jika ada)
        $application = TaskApplication::where('task_id', $id)
            ->where('profile_id', Auth::id())
            ->first();

        return view('worker.manageWorker', compact('task', 'application'));
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        // Hanya bisa dihapus kalau status-nya "open"
        if ($task->status !== 'open') {
            return redirect()->back()->with('error', 'Task tidak bisa dihapus karena sudah dalam proses.');
        }

        // Hapus file terkait jika ada
        if ($task->job_file) {
            Storage::disk('public')->delete($task->job_file);
        }

        $task->delete();

        return redirect()->route('jobs.my')->with('success', 'Task berhasil dihapus.');
    }


    public function apply(Request $request, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $profileId = WorkerProfile::where('user_id', Auth::id())->value('id');

        // Cek apakah sudah pernah melamar
        $existing = TaskApplication::where('task_id', $taskId)
            ->where('profile_id', $profileId)
            ->first();

        if ($existing) {
            return back()->with('error', 'Kamu sudah melamar task ini.');
        }

        TaskApplication::create([
            'task_id' => $taskId,
            'profile_id' => $profileId,
            'bidPrice' => $request->bidPrice,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'applied_at' => now(),
        ]);
        return back()->with('success', 'Lamaran berhasil dikirim.');
    }
    public function accept($applicationId)
    {
        $application = TaskApplication::findOrFail($applicationId);
        $task = $application->task;

        // Update task
        $task->update([
            'profile_id' => $application->profile_id,
            'status' => 'in progress',
        ]);

        // Update status lamaran
        $application->update(['status' => 'accepted']);

        // Optional: Tolak lamaran lain
        TaskApplication::where('task_id', $task->id)
            ->where('id', '!=', $application->id)
            ->update(['status' => 'rejected']);

        return back()->with('success', 'Worker berhasil diterima. Task dimulai.');
    }

    //function hire
    public function Clienthire(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:task,id',
            'worker_profile_id' => 'required|exists:worker_profiles,id',
        ]);

        $task = Task::find($request->task_id);

        // 1. Cek apakah sudah bayar
        if (!$task->bayar) {
            return back()->with('error', 'Silakan bayar terlebih dahulu sebelum merekrut worker.');
        }

        $profile = WorkerProfile::findOrFail($request->worker_profile_id);

        // 2. Update task
        $task->profile_id = $profile->id;
        $task->status = 'in progress';
        $task->save();

        TaskApplication::where('task_id', $task->id)->delete();

        return back()->with('success', 'Worker berhasil direkrut, dan semua lamaran lainnya telah dihapus.');
    }

    //tolak worker
    public function ClientReject(Request $request)
    {
        $request->validate([
            'application_id' => 'required|exists:task_applications,id',
        ]);

        $application = TaskApplication::findOrFail($request->application_id);
        // $task = Task::findOrFail($request->task_id);
        $user = Auth::user();

        // Simpan notifikasi untuk worker
        Notification::create([
            'user_id' => $application->worker->user_id,
            'sender_name' => $user->nama_lengkap,
            'message' => 'Lamaran kamu untuk task <b>"' . $application->task->title . '"</b> telah ditolak.',
            'is_read' => false,
        ]);

        $application->delete();

        return back()->with('success', 'Lamaran berhasil dihapus.');
    }

    //pay
    public function bayar(Request $request, Task $task)
    {
        try {
            // Set Midtrans configuration
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Get data from request
            $id = $request->id_order;
            $amount = $request->amount;

            // Find the task and client
            $task = Task::findOrFail($id);
            $client = User::findOrFail($task->client_id);


            // Generate a unique order ID by appending timestamp
            $uniqueOrderId = $id . '-' . time();

            // Set Midtrans parameters
            $params = array(
                'transaction_details' => array(
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $amount,
                ),
                'customer_details' => array(
                    'first_name' => $client->nama_lengkap,
                    'last_name' => '',
                    'email' => $client->email,
                    'phone' => $client->nomor_telepon,
                ),
            );

            // Get Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Return back to the same page with the snap token
            return back()->with([
                'snap_token' => $snapToken,
                'order_id' => $uniqueOrderId,
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            if (strpos($errorMessage, 'order_id sudah digunakan') !== false) {
                return back()->with('error', 'Order ID sudah digunakan. Silakan coba lagi.');
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $errorMessage);
        }
    }

    function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hash = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hash === $request->signature_key) {
            if ($request->transaction_status === 'capture') {
                $task = Task::where('id', $request->order_id)->first();
                if ($task->bayar == 0) {
                    $task->bayar = true;
                    $task->price = $request->gross_amount;
                    $task->save();
                } else if ($task->bayar == 1) {
                    $task->price = $task->price + $request->gross_amount;
                    $task->save();
                }
            } elseif ($request->transaction_status === 'pending') {
                // Handle pending status
            } elseif ($request->transaction_status === 'cancel' || $request->transaction_status === 'expire') {
                // Handle cancel or expire status
            }
        } else {
            return response()->json(['error' => 'Invalid signature'], 400);
        }
    }

    function invoice($id)
    {
        $task = Task::where('id', $id)->first();

        if (!$task) {
            return redirect()->back()->with('error', 'Task not found.');
        }

        return view('client.Jobs.invoice', compact('task'));
    }

    // Fungsi tampilan detail Job yang sudah in progres
    public function DetailJobsInProgress($id)
    {
        $task = Task::with('user')->findOrFail($id);

        $progressionsByStep = Progression::with('task')
            ->where('task_id', $task->id)
            ->get()
            ->keyBy('progression_ke');

        $progressions = $progressionsByStep->values();

        $steps = [];
        for ($i = 1; $i <= 4; $i++) {
            if (isset($progressionsByStep[$i])) {
                $steps['step' . $i] = $progressionsByStep[$i]->status_approve ?? 'pending';
            } else {
                $steps['step' . $i] = 'pending';
            }
        }

        // Tentukan apakah worker bisa mengunggah file
        $currentStep = $progressionsByStep->keys()->max() + 1;
        $canSubmit = $this->determineCanSubmit($currentStep, $progressionsByStep);

        if ($task->status !== 'completed') {
            return view('General.detailProgressionJobs', compact(
                'task',
                'steps',
                'progressionsByStep',
                'progressions',
                'canSubmit' // jangan lupa lempar ke view kalau mau dipakai
            ));
        } else {
            return view('General.detailProgressionComplite', compact(
                'task',
                'progressions',
            ));
        }
    }


    private function determineCanSubmit($step, $progressionsByStep)
    {
        $canSubmit = false;

        $third = $progressionsByStep[3] ?? null;
        $fourth = $progressionsByStep[4] ?? null;

        // Ambil data task terkait
        $task = $third?->task ?? null;

        // Cek jika task ada dan memiliki kolom revisions
        $taskRevisions = $task ? $task->revisions : 0;

        // Hitung revisi yang sudah ada di progression (dari step 4 dan seterusnya)
        $currentRevisions = Progression::where('task_id', $third->task_id ?? null)
            ->where('progression_ke', '>=', 4) // Memperhitungkan revisi setelah step 3
            ->count();

        // Jika ini adalah step pertama, cek apakah progression pertama sudah disetujui
        if ($step == 1) {
            if (isset($progressionsByStep[1]) && $progressionsByStep[1]->status_approve == 'approved') {
                $canSubmit = true;
            }
        }

        // Special rules for step 4 (revisi)
        if ($step == 4) {
            // Cek apakah revisi masih diizinkan
            if (!$fourth && $third && $third->status_approve === 'rejected' && $currentRevisions < $taskRevisions) {
                $canSubmit = true;
            }
        }

        // Jika revisi yang sudah dilakukan lebih sedikit dari yang diizinkan, tombol submit harus muncul
        if ($currentRevisions < $taskRevisions) {
            $canSubmit = true;
        }

        return $canSubmit;
    }
}
