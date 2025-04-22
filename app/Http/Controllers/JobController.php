<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\task;
use App\Models\TaskApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\WorkerProfile;
use App\Models\User;

class JobController extends Controller
{
    // List All Jobs 
    public function index()
    {
        $jobs = task::all();
        return view('jobs', compact('jobs'));
    }


    // Create job Client
    public function store(Request $request)
    {
        $request->validate([
            //     'title' => 'required|string|max:255',
            //     'description' => 'required|string',
            //     'price' => 'required|numeric',
            //     'deadline' => 'required|date',
            //     'deadline_promotion' => 'required|date',
            //     'provisions' => 'nullable|string',
            //     'revisions' => 'required|integer',
            //     'taskType' => 'required|in:paid,free',
            'job_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240',// max 2MB
        ]);

        // Handle file upload jika ada
        $path = null;
        if ($request->hasFile('job_file')) {
            $path = $request->file('job_file')->store('task_files', 'public');
        }

        // dd($request->hasFile('job_file'), $path);
        // dd($request->all());
        // dd([
        //     'path' => $path,
        //     'job_file_input' => $request->file('job_file'),
        //     'job_file_name' => $request->file('job_file')?->getClientOriginalName(),
        // ]);

        $task = Task::create([
            // 'id' => Str::uuid(),
            'client_id' => Auth::id(),
            'profile_id' => null, // default null, nanti diassign saat ada worker apply
            'title' => $request->title,
            'description' => $request->description,
            'deadline' => $request->deadline,
            'deadline_promotion' => $request->deadline_promotion,
            'provisions' => $request->provisions,
            'price' => $request->price,
            'status' => 'open',
            'revisions' => $request->revisions,
            'taskType' => $request->taskType,
            'job_file' => $path,
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully.');
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
        $applicants = TaskApplication::with([
            'worker.user',
            'worker.certifications.images',
            'worker.portfolios.images',
        ])
        ->where('task_id', $id)
        ->get();
        // Kirim ke view
        return view('General.showJobsDetail', compact('job','applicants'));
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
        $taskApplied = TaskApplication::with(['task', 'profile'])
        ->where('profile_id', $workerProfile->id)
        ->get();
        return view('Worker.Jobs.myJobWorker', compact('taskApplied'));
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
    
        return view('manageWorker', compact('task', 'application'));
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
        $task->profile_id = $profile->user_id;
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
    
        TaskApplication::where('id', $request->application_id)->delete();
    
        return back()->with('success', 'Lamaran berhasil dihapus.');
    }

    //pay
    public function bayar(Request $request)
    {
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;
        $id = $request->task->id;
        $task = Task::findOrFail($id);
        $client = User::findOrFail($task->client_id);
        $amount = $request->amount;
 
        $params = array(
            'transaction_details' => array(
                'order_id' => $id,
                'gross_amount' => $amount,
            ),
            'customer_details' => array(
                'first_name' => $client->nama_lengkap,
                'last_name' => '',
                'email' => $client->email,
                'phone' => $client->nomor_telepon,
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $dd($snapToken);
    }


}
