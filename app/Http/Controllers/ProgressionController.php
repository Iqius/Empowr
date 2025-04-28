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

        // Update task dengan data baru
        $task->update([
            'status' => 'completed', // Misal ada status yang bisa diubah
        ]);

        $workerProfile = WorkerProfile::findOrFail($task->profile_id);
        $user = User::findOrFail($workerProfile->user_id);

        $user->ewallet += $task->price; // atau sesuai nama kolom saldo kamu
        $user->save();

        // Ambil progression terakhir yang terkait dengan task
        $lastProgression = Progression::where('task_id', $taskId)
        ->orderBy('created_at', 'desc') // Ambil yang paling terbaru
        ->first();

        if ($lastProgression) {
            // Hapus progression lain kecuali yang terakhir
            Progression::where('task_id', $taskId)
                ->where('id', '!=', $lastProgression->id)
                ->delete();
        }

        return redirect()->route('jobs.index')->with('success-updated', 'Job updated successfully.');
    }
}