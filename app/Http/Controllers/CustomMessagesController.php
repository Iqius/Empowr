<?php

namespace App\Http\Controllers;

use Chatify\Http\Controllers\MessagesController as BaseMessagesController;
use Illuminate\Http\Request;
use App\Models\ChMessage;

class CustomMessagesController extends BaseMessagesController
{
    public function fetchMessages(Request $request)
    {
        // Ambil semua pesan yang dikirim ke user yang login
        $userId = auth()->id();

        $messages = ChMessage::with(['fromUser', 'toUser'])
            ->where('to_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'messages' => $messages
        ]);
    }
}
