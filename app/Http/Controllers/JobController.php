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
use App\Models\Transaction;
use App\Models\UserPaymentAccount;
use App\Models\Ewallet;
use App\Models\User;
use App\Models\workerAffiliated;
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

        $user = Auth::user();
        if($user->role == 'admin'){
            $task = Task::where('id', $id)->firstOrFail();
        }else{
            $task = Task::with('user')->findOrFail($id);
        }
        

        $userId = Auth::id();

        $ewallet = Ewallet::where('user_id', $userId)->first();
        
        // Contoh akses saldo ewallet dengan null safe
        
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

        return view('client.jobs.manage', compact('task', 'applicants','ewallet'));
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

    //BAYAR
    public function bayar(Request $request, Task $task = null)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Ambil data dari request
            $amount = $request->amount;
            $paymentMethod = $request->input('payment_method');
            $type = $request->input('type'); 

            // Untuk payment type 'payment', harus ada task dan worker_profile_id
            if ($type === 'payment') {
                $id = $request->id_order;
                $workerProfileId = $request->worker_profile_id;

                $task = Task::findOrFail($id);
                $client = User::findOrFail($task->client_id);

                $workerId = $workerProfileId; // sesuaikan jika perlu cari worker id

                $uniqueOrderId = $id . '-' . $workerProfileId . '-' . time();

                $transaction = Transaction::create([
                    'order_id' => $uniqueOrderId,
                    'task_id' => $id,
                    'worker_id' => $workerId,
                    'client_id' => $client->id,
                    'amount' => $amount,
                    'status' => 'pending',
                    'type' => 'payment',
                    'payment_method' => $paymentMethod,
                ]);
                

                // Customer details dari client
                $customer = [
                    'first_name' => $client->nama_lengkap,
                    'last_name' => '',
                    'email' => $client->email,
                    'phone' => $client->nomor_telepon,
                ];

            } elseif ($type === 'topup') {
                // Untuk topup, dapat client_id atau worker_id (misal lewat request)
                // Contoh: topup untuk user tertentu (client/worker)

                // Misal topup untuk client_id (harus ada di form/request)
                $clientId = $request->input('client_id'); // boleh null
                $workerId = $request->input('worker_id'); // boleh null

                if (!$clientId && !$workerId) {
                    return back()->with('error', 'Topup harus ditujukan ke client atau worker.');
                }

                // Generate order id unik
                $uniqueOrderId = 'topup-' . ($clientId ?? $workerId) . '-' . time();

                $transaction = Transaction::create([
                    'order_id' => $uniqueOrderId,
                    'task_id' => null,
                    'worker_id' => $workerId,
                    'client_id' => $clientId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'type' => 'topup',
                ]);

                

                // Cari data customer agar bisa kirim ke Midtrans
                if ($clientId) {
                    $user = User::findOrFail($clientId);
                } elseif ($workerId) {
                    $workerProfile = WorkerProfile::findOrFail($workerId);
                    $user = $workerProfile->user;  // Ini akan ngambil data user terkait
                }

                $customer = [
                    'first_name' => $user->nama_lengkap ?? $user->name ?? 'User',
                    'last_name' => '',
                    'email' => $user->email ?? 'user@example.com',
                    'phone' => $user->nomor_telepon ?? '08123456789',
                ];
            } else {
                return back()->with('error', 'Tipe pembayaran tidak valid.');
            }

            // Set parameter Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $amount,
                ],
                'customer_details' => $customer,
            ];

            $snapToken = Snap::getSnapToken($params);

            return back()->with([
                'snap_token' => $snapToken,
                'order_id' => $uniqueOrderId,
                'amount' => $amount,
            ]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            if (strpos($errorMessage, 'order_id sudah digunakan') !== false) {
                return back()->with('error', 'Order ID sudah digunakan. Silakan coba lagi.');
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $errorMessage);
        }
    }


    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hash = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hash !== $request->signature_key) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
            if ($transaction->status !== 'success') {
                $transaction->status = 'success';
                $transaction->save();

                if ($transaction->type === 'payment') {
                    $task = $transaction->task;
                    if ($task) {
                        $hasAffiliate = TaskApplication::where('task_id', $task->id)
                            ->where('affiliated', true)
                            ->exists();

                        // Kalau ada affiliated = true, update task dengan informasi khusus affiliate (opsional)
                        if ($hasAffiliate) {
                            $task->status = 'in progress'; // atau bisa disesuaikan
                            $task->profile_id = $transaction->worker_id;
                            $task->client_id = $transaction->client_id;
                            $task->status_affiliate = true;
                            $task->price = $transaction->amount;
                            $task->save();

                            // Bisa juga skip penghapusan task application kalau dibutuhkan
                            TaskApplication::where('task_id', $task->id)->delete();
                        } else {
                            // Kalau bukan affiliate
                            $task->price = $transaction->amount;
                            $task->profile_id = $transaction->worker_id;
                            $task->client_id = $transaction->client_id;
                            $task->status_affiliate = false;
                            $task->status = 'in progress';
                            $task->save();

                            TaskApplication::where('task_id', $task->id)->delete();
                        }
                    }
                } elseif ($transaction->type === 'topup') {
                    $userId = $transaction->client_id ?? $transaction->worker_id;

                    $ewalet = Ewallet::where('user_id', $userId)->first();
                    if ($ewalet) {
                        $ewalet->balance += $transaction->amount;
                        $ewalet->save();
                    } else {
                        Ewallet::create([
                            'user_id' => $userId,
                            'balance' => $transaction->amount,
                        ]);
                    }
                }
            }
        } elseif ($request->transaction_status === 'pending') {
            $transaction->status = 'pending';
            $transaction->save();
        } elseif ($request->transaction_status === 'cancel' || $request->transaction_status === 'expire') {
            $transaction->status = $request->transaction_status;
            $transaction->save();
        }

        return response()->json(['success' => true]);
    }



    public function bayarEwalletBase(Request $request)
    {
        // Ambil user yang login
        $user = auth()->user();
        $taskId = $request->input('task_id');
        $task = Task::find($taskId);
        // Ambil data yang diperlukan
        $amount = $request->amount ?? $task->price;
        $paymentMethod = $request->input('payment_method');
        $type = $request->input('type');
        $workerId = $request->worker_profile_id ?? $task->profile_id;
        
        
        // Ambil ewallet user
        $ewallet = Ewallet::where('user_id', $user->id)->first();

        if (!$ewallet) {
            return back()->with('error', 'Ewallet tidak ditemukan.');
        }

        // Cek saldo cukup
        if ($ewallet->balance < $amount) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $hasAffiliate = TaskApplication::where('task_id', $task->id)
            ->where('affiliated', true)
            ->exists();

        if ($hasAffiliate) {
            // Potong saldo ewallet
            $ewallet->balance -= $amount;
            $ewallet->save();

            $task->update([
                'price' => $amount,
                'profile_id' => $workerId,
                'client_id' => $user->id,
                'status_affiliate' => true,
                'status' => 'in progress',
            ]);
        } else {
            // Potong saldo ewallet
            $ewallet->balance -= $amount;
            $ewallet->save();

            $task->update([
                'price' => $amount,
                'profile_id' => $workerId,
                'client_id' => $user->id,
                'status_affiliate' => false,
                'status' => 'in progress',
            ]);
        }
        
        // Hapus semua aplikasi task
        TaskApplication::where('task_id', $task->id)->delete();
        
        // Buat unique order ID dan transaksi pembayaran
        $uniqueOrderId = $taskId . '-' . $workerId . '-' . time();
        
        Transaction::create([
            'order_id' => $uniqueOrderId,
            'task_id' => $taskId,
            'worker_id' => $workerId,
            'client_id' => $user->id,
            'amount' => $amount,
            'status' => 'success',
            'type' => $type,
            'payment_method' => $paymentMethod,
        ]);

        return redirect()->route('jobs.my')->with('success', 'Pembayaran berhasil menggunakan e-wallet.');
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


    public function ewalletIndex()
    {
        $userId = Auth::id();

        $ewallet = Ewallet::where('user_id', $userId)->first();

        $paymentAccounts = UserPaymentAccount::where('user_id', $userId)->first();

        $transactions = Transaction::where('worker_id', $userId)
                        ->orWhere('client_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('General.ewallet', compact('ewallet', 'paymentAccounts', 'transactions'));
    }
}






// gadipake

// public function accept($applicationId)
//     {
//         $application = TaskApplication::findOrFail($applicationId);
//         $task = $application->task;

//         // Update task
//         $task->update([
//             'profile_id' => $application->profile_id,
//             'status' => 'in progress',
//         ]);

//         // Update status lamaran
//         $application->update(['status' => 'accepted']);

//         // Optional: Tolak lamaran lain
//         TaskApplication::where('task_id', $task->id)
//             ->where('id', '!=', $application->id)
//             ->update(['status' => 'rejected']);

//         return back()->with('success', 'Worker berhasil diterima. Task dimulai.');
//     }