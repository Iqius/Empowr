<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index(Job $job, User $user)
    {
        $messages = Message::where('job_id', $job->id)
            ->where(function ($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id)
                  ->orWhere('sender_id', $user->id)->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at')
            ->get();

        return view('chat', compact('messages', 'job', 'user'));
    }

    public function send(Request $request, Job $job, User $user)
    {
        Message::create([
            'job_id' => $job->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'message' => $request->message
        ]);

        return back();
    }
}
