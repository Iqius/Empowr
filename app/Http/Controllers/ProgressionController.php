<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Progression;
use App\Models\task;
use App\Models\WorkerProfile;
use App\Models\TaskReview;
use App\Models\Ewallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ProgressionController extends Controller
{
    //create progress sisi worker
    public function create(Request $request, $taskId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
        ]);

        $filePath = $request->file('file')->store('progression_files', 'public');
        $user = auth()->id();
        Progression::create([
            'task_id' => $taskId,
            'path_file' => $filePath,
            'action_by_worker' => $user,
            'status_upload' => 'uploaded',
            'status_approve' => 'waiting',
            'note' => null,
            'date_upload' => now(),
            'date_approve' => null,
            'progression_ke' => Progression::where('task_id', $taskId)->count() + 1,
        ]);


        return back()->with('success-progression', 'Progress berhasil dikirim.');
    }

    //review progress sisi client
    public function review(Request $request, Progression $progress)
    {
        $request->validate([
            'status_approve' => 'required|in:approved,rejected',
            'note' => 'nullable|string',
        ]);

        $userId = auth()->id();

        // Ambil task terkait
        $task = $progress->task;

        // Cek apakah user yang login adalah client dari task ini
        if ($userId !== $task->client_id) {
            abort(403, 'Unauthorized action.');
        }

        // Kalau aman, buat Progression baru
        $progress->update([
            'status_approve' => $request->status_approve,
            'note' => $request->note,
            'date_approve' => now(),
            'action_by_client' => $userId,
        ]);

        return back()->with('success-review', 'Progression berhasil direview.');
    }

    public function CompliteJob(Request $request, $taskId)
    {
        // Ambil task berdasarkan taskId
        $task = task::findOrFail($taskId);
        if(auth()->user()->id === $task->client_id) { // Pastikan yang memberi review adalah client yang sesuai
            // Validasi rating dan komentar
            $request->validate([
                'rating' => 'required|integer|between:1,5', // Rating 1 - 5
                'comment' => 'nullable|string|max:500', // Komentar opsional
            ]);
    
            $review = TaskReview::where('task_id', $task->id)
                ->where('user_id', auth()->user()->id)
                ->firstOrFail();

            $review->update([
                'rating' => $request->rating,
                'comment' => $request->review,
            ]);

        }

        $task->update([
            'status' => 'completed',
        ]);
        
        if($task->status_affiliate == true){
            $workerProfile = WorkerProfile::findOrFail($task->profile_id);
            $userId = $workerProfile->user_id;
            $ewallet = Ewallet::where('user_id', $userId)->first();
            if ($ewallet) {
                $ewallet->balance += $task->price;
                $ewallet->save();
            }

            
            // Buat transaksi untuk gaji worker
            $orderId = 'selesai-' . $task->id . '-' . time();
            Transaction::create([
                'order_id' => $orderId,              // ID order
                'task_id' => $task->id,                  // ID task
                'worker_id' => $workerProfile->id,       // ID worker profile
                'client_id' => auth()->user()->id,       // ID client
                'amount' => $task->harga_task_affiliate,
                'status' => 'success',
                'type' => 'salary',
            ]);
            
        }else{
            $workerProfile = WorkerProfile::findOrFail($task->profile_id);
            $userId = $workerProfile->user_id;
            $ewallet = Ewallet::where('user_id', $userId)->first();
            if ($ewallet) {
                $ewallet->balance += $task->harga_task_affiliate;
                $ewallet->save();
            }

            
            // Buat transaksi untuk gaji worker
            $orderId = 'selesai-' . $task->id . '-' . time();
            Transaction::create([
                'order_id' => $orderId,              // ID order
                'task_id' => $task->id,                  // ID task
                'worker_id' => $workerProfile->id,       // ID worker profile
                'client_id' => auth()->user()->id,       // ID client
                'amount' => $task->price,
                'status' => 'success',
                'type' => 'salary',
            ]);
        }
        
        
        $lastProgression = Progression::where('task_id', $taskId)
            ->orderBy('created_at', 'desc')
            ->first();
        if ($lastProgression) {
            Progression::where('task_id', $taskId)
                ->where('id', '!=', $lastProgression->id)
                ->delete();
        }
        return redirect()->route('jobs.index')->with('success-updated', 'Job updated successfully.');
    }

    public function ulasanWorker(Request $request, $taskId)
    {
        $task = task::findOrFail($taskId);

        $request->validate([
            'rating' => 'required|integer|between:1,5', // Rating 1 - 5
            'comment' => 'nullable|string|max:500', // Komentar opsional
        ]);

        $review = TaskReview::where('task_id', $task->id)
            ->where('user_id', auth()->user()->id)
            ->firstOrFail();

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->review,
        ]);

        return redirect()->route('jobs.index')->with('success-review', 'Pekerjaan sudah diberikan ulasan terima kasih.');
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
        $totalSteps = 3 + ($task->revisions ?? 0);

$steps = [];

// Step 1–3 biasa
for ($i = 1; $i <= 3; $i++) {
    if (isset($progressionsByStep[$i])) {
        $steps['step' . $i] = $progressionsByStep[$i]->status_approve ?? 'pending';
    } else {
        $steps['step' . $i] = 'pending';
    }
}

// Step 4 (Selesai) → ambil dari hasil revisi, bukan langsung dari step ke-4
$revisions = Progression::where('task_id', $task->id)
    ->where('progression_ke', '>=', 4)
    ->orderByDesc('progression_ke')
    ->get();

$approvedRevision = $revisions->firstWhere('status_approve', 'approved');
$maxRevision = $task->revisions ?? 0;
$currentRevisions = $revisions->count();

if ($approvedRevision) {
    $steps['step4'] = 'approved';
} elseif ($currentRevisions >= $maxRevision) {
    $steps['step4'] = $revisions->first()?->status_approve ?? 'rejected';
} else {
    $steps['step4'] = 'pending';
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