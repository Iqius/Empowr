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


        return back()->with('success', 'Progress berhasil dikirim.');
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

        return back()->with('success', 'Progression berhasil direview.');
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
    
            // Simpan rating dan komentar ke dalam tabel task_reviews
            TaskReview::create([
                'task_id' => $task->id,
                'user_id' => auth()->user()->id, // User yang memberikan ulasan (client)
                'reviewed_user_id' => $task->worker->user->id, // Worker yang menerima ulasan
                'rating' => $request->rating, // Rating
                'comment' => $request->review, // Komentar
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

        // Simpan rating dan komentar ke dalam tabel task_reviews
        TaskReview::create([
            'task_id' => $task->id,
            'user_id' => auth()->user()->id, // User yang memberikan ulasan (client)
            'reviewed_user_id' => $task->client->id, // Worker yang menerima ulasan
            'rating' => $request->rating, // Rating
            'comment' => $request->review, // Komentar
        ]);

        return redirect()->route('jobs.index')->with('success-review', 'Pekerjaan sudah diberikan ulasan terima kasih.');
    }
}