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
use App\Models\WorkerAffiliated;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\TaskReview;

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


    /// Create job Client
    public function createJobClient(Request $request)
    {
        $request->validate([
            'job_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240', // max 10MB
        ]);

        $path = null; // Default null, kalau tidak ada file

        if ($request->hasFile('job_file')) {
            $file = $request->file('job_file');

            // Gunakan nama asli + timestamp supaya unik
            $originalName = time() . '_' . $file->getClientOriginalName();

            // Simpan file ke storage/app/public/task_files
            $path = $file->storeAs('task_files', $originalName, 'public');
        }

        // Simpan job ke database
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
            'category' => json_encode($request->category),
            'job_file' => $path, // akan null jika tidak upload
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
            'category' => $request->kategoriWorker ? json_encode($request->kategoriWorker) : $task->category,
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
        foreach ($applicants as $applicant) {
            $user = $applicant->worker->user ?? null;

            if ($user) {
                $ratingData = TaskReview::where('reviewed_user_id', $user->id)->get();
                $applicant->avgRating = $ratingData->avg('rating') ?? 0;
            } else {
                $applicant->avgRating = 0;
            }
        }

        $job = Task::with('user')->findOrFail($id);

        $clientUser = $job->user;

        if ($clientUser) {
            $ratingData = TaskReview::where('reviewed_user_id', $clientUser->id)->get();
            $clientUser->avgRating = $ratingData->avg('rating') ?? 0;
        }

        // Cek apakah user ini sudah melamar task tersebut
        $hasApplied = TaskApplication::where('task_id', $id)
            ->where('profile_id', $profileId)
            ->exists();

        // Kirim ke view, tambahkan variabel $hasApplied
        return view('General.showJobsDetail', compact('job', 'applicants', 'hasApplied'));
    }
    public function myJobs()
    {
        $now = now();

        // Ambil semua task milik client
        $task = Task::where('client_id', Auth::id())
            ->where(function ($query) use ($now) {
                $query->where('deadline_promotion', '>=', $now)
                    ->orWhereHas('applications'); // tampilkan juga yang expired tapi punya pelamar
            })
            ->get();

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

        $task = $user->role === 'admin'
            ? Task::findOrFail($id)
            : Task::with('user')->findOrFail($id);

        $ewallet = Ewallet::where('user_id', $user->id)->first();

        // Ambil parameter sorting dari request
        $sortBy = $request->get('sort', 'bidPrice');
        $sortDir = $request->get('dir', 'asc');
        $allowedSorts = ['bidPrice', 'experience', 'rating'];
        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'bidPrice';
        }

        // Ambil semua pelamar
        $allApplicants = TaskApplication::with([
            'worker.user',
            'worker.certifications.images',
            'worker.portfolios.images',
        ])->where('task_id', $id)->get();

        // Hitung rating masing-masing pelamar
        foreach ($allApplicants as $applicant) {
            $user = $applicant->worker->user ?? null;
            $applicant->avgRating = $user
                ? TaskReview::where('reviewed_user_id', $user->id)->avg('rating') ?? 0
                : 0;
        }

        // Pisahkan affiliate dan regular
        $affiliateApplicants = $allApplicants->filter(function ($a) {
            return in_array($a->worker->empowr_affiliate ?? 0, [1, '1'], true);
        })->values();

        $regularApplicants = $allApplicants->reject(function ($a) {
            return in_array($a->worker->empowr_affiliate ?? 0, [1, '1'], true);
        })->values();

        // Sort regular applicants saja
        if ($sortBy === 'experience') {
            $regularApplicants = $regularApplicants->sortBy(function ($a) {
                return $a->worker->pengalaman_kerja ?? 0;
            }, SORT_REGULAR, $sortDir === 'desc');
        } elseif ($sortBy === 'rating') {
            $regularApplicants = $regularApplicants->sortBy(function ($a) {
                return $a->avgRating ?? 0;
            }, SORT_REGULAR, $sortDir === 'desc');
        } else {
            $regularApplicants = $regularApplicants->sortBy(function ($a) use ($sortBy) {
                return $a->{$sortBy} ?? 0;
            }, SORT_REGULAR, $sortDir === 'desc');
        }

        // Gabungkan: affiliate tetap di atas
        $applicants = $affiliateApplicants->concat($regularApplicants)->values();

        return view('client.jobs.manage', compact('task', 'applicants', 'ewallet'));
    }







    public function manageWorker($id)
    {
        $task = Task::with('user')->findOrFail($id);
        $profileId = Auth::user()->workerProfile->id;

        // Cari lamaran user ini (jika ada)
        $application = TaskApplication::where('task_id', $id)
            ->where('profile_id', $profileId)
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

    public function search(Request $request)
    {
        $query = $request->q;
        $sort = $request->sort;

        $tasks = Task::with('user')->where('title', 'like', '%' . $query . '%');

        if ($sort === 'price-asc') {
            $tasks = $tasks->orderBy('price', 'asc');
        } elseif ($sort === 'price-desc') {
            $tasks = $tasks->orderBy('price', 'desc');
        }

        $tasks = $tasks->get();

        $html = view('components.job-cards', ['jobs' => $tasks])->render();
        return response($html);
    }

    public function updateBidPrice(Request $request, TaskApplication $application)
    {
        try {
            // 1. Validasi Data
            $request->validate([
                'bidPrice' => 'required|numeric|min:0',
            ], [
                'bidPrice.required' => 'Harga penawaran wajib diisi.',
                'bidPrice.numeric' => 'Harga penawaran harus berupa angka.',
                'bidPrice.min' => 'Harga penawaran tidak boleh negatif.',
            ]);

            // 2. Perbarui bidPrice
            $application->bidPrice = $request->bidPrice;
            $application->save();

            // 3. Redirect kembali dengan pesan sukses
            return back()->with('success', 'Harga penawaran berhasil diperbarui.');
        } catch (ValidationException $e) {
            // Jika ada error validasi, redirect kembali dengan error
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // Tangani error umum lainnya (misalnya, masalah database)
            return back()->with('error', 'Gagal memperbarui harga penawaran. Pesan error: ' . $e->getMessage());
        }
    }
    public function handleExpiredPromotionTasks()
    {
        $today = now();

        // Ambil task yang sudah melewati deadline_promotion
        $expiredTasks = Task::whereDate('deadline_promotion', '<', $today)->get();

        foreach ($expiredTasks as $task) {
            // Hitung jumlah pelamar
            $applicationsCount = TaskApplication::where('task_id', $task->id)->count();

            if ($applicationsCount == 0) {
                // Hapus jika tidak ada pelamar
                if ($task->job_file && Storage::disk('public')->exists($task->job_file)) {
                    Storage::disk('public')->delete($task->job_file);
                }

                $task->delete();
            }

            // Jika ada pelamar, cukup tandai untuk ditampilkan khusus di dashboard client
            // Tidak perlu update apa-apa, cukup filter nanti saat render view
        }

        return response()->json(['message' => 'Expired tasks handled.']);
    }
}