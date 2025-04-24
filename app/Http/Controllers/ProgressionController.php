<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Midtrans\Config;
use Midtrans\Snap;
use App\Models\Progression;

class ProgressionController extends Controller
{
    //create progress sisi worker
    public function create(Request $request, $taskId)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg|max:2048',
        ]);

        $filePath = $request->file('file')->store('progression_files', 'public');

        Progression::create([
            'task_id' => $taskId,
            'path_file' => $filePath,
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

        $progress->update([
            'status_approve' => $request->status_approve,
            'note' => $request->note,
            'date_approve' => now(),
        ]);

        return back()->with('success', 'Progression berhasil direview.');
    }
}