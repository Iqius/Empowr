<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    //semua chat
    public function index()
    {
        // Get all conversations for the authenticated user
        $conversations = Conversation::where('user_id', Auth::id())
            ->with('otherUser') // Eager load the other user
            ->orderBy('last_time_message', 'desc')
            ->get();
        
        return view('chat.chat', [
            'conversations' => $conversations,
            'isAdmin' => Auth::user()->role === 'admin' // Pass admin status to view
        ]);
    }
    
    //spesifik chat
    public function show($userId)
{
    // Find the other user
    $otherUser = User::findOrFail($userId);
    
    // Find or create conversation between authenticated user and the specified user
    $conversation = $this->findOrCreateConversation($userId);
    
    // Mark all unread messages as read
    $this->markMessagesAsRead($conversation);
    
    // Get messages for this conversation
    $messages = $conversation->messages()->with(['sender', 'receiver'])->get();
    
    // Get all conversations for the sidebar
    $conversations = Conversation::where('user_id', Auth::id())
        ->with('otherUser')
        ->orderBy('last_time_message', 'desc')
        ->get();
    
    return view('chat.chat', [
        'conversation' => $conversation,
        'otherUser' => $otherUser,
        'messages' => $messages,
        'conversations' => $conversations,
        'isAdmin' => Auth::user()->role === 'admin' // Pass admin status to view
    ]);
}
    
//menyimpan pesan
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|max:10240', // Max 10MB
        ]);
        
        // Cannot send message to yourself
        if ($request->receiver_id == Auth::id()) {
            return redirect()->back()->with('error', 'You cannot send a message to yourself');
        }
        
        // Create the message
        $message = new Message();
        $message->sender_id = Auth::id();
        $message->receiver_id = $request->receiver_id;
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store('attachments', 'public');
            $message->attachment = $path;
            
            // Determine attachment type based on file mime type
            $mime = $file->getMimeType();
            if (strstr($mime, 'image/')) {
                $message->attachment_type = 'image';
            } else {
                $message->attachment_type = 'file';
            }
        } 
        // Handle text message
        elseif ($request->has('message')) {
            $message->message = $request->message;
        }
        
        $message->save();

        // Update or create conversations for both users
        $this->updateConversations(Auth::id(), $request->receiver_id);
        
        // For AJAX requests, return JSON
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender')
            ]);
            Notification::create([
                'user_id' => $request->receiver_id,
                'sender_name' => $user->nama_lengkap ?? $user->username,
                'message' => $messageText ?? '[No message]',
                'is_read' => false,
        ]);
        }
        
        // For traditional form submissions, redirect
        return redirect()->back();
    }
    
//search user admin
    public function search(Request $request)
    {
        // Check if user is admin
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        $query = $request->input('query');
        
        $users = User::where('id', '!=', Auth::id())
            ->where(function($q) use ($query) {
                $q->where('username', 'LIKE', "%{$query}%")
                  ->orWhere('nama_lengkap', 'LIKE', "%{$query}%") 
                  ->orWhere('email', 'LIKE', "%{$query}%");
            })
            ->take(10)
            ->get();
        
        // For AJAX requests
        if ($request->ajax()) {
            return response()->json($users);
        }
        
        // For traditional requests
        return view('chat.search_results', [
            'users' => $users,
            'query' => $query
        ]);
    }
    
    /**
     * Find or create a conversation between two users
     */
    private function findOrCreateConversation($otherUserId)
    {
        // Try to find existing conversation
        $conversation = Conversation::where('user_id', Auth::id())
            ->where('other_user_id', $otherUserId)
            ->first();
        
        // If no conversation exists, create a new one
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_id' => Auth::id(),
                'other_user_id' => $otherUserId,
                'last_time_message' => now(),
            ]);
            
            // Also create the reverse conversation (from other user's perspective)
            Conversation::create([
                'user_id' => $otherUserId,
                'other_user_id' => Auth::id(),
                'last_time_message' => now(),
            ]);
        }
        
        return $conversation;
    }
    
    /**
     * Update conversations for both users
     */
    private function updateConversations($senderId, $receiverId)
    {
        // Update sender's conversation
        $senderConversation = Conversation::where('user_id', $senderId)
            ->where('other_user_id', $receiverId)
            ->first();
        
        if ($senderConversation) {
            $senderConversation->update(['last_time_message' => now()]);
        } else {
            Conversation::create([
                'user_id' => $senderId,
                'other_user_id' => $receiverId,
                'last_time_message' => now(),
            ]);
        }
        
        // Update receiver's conversation
        $receiverConversation = Conversation::where('user_id', $receiverId)
            ->where('other_user_id', $senderId)
            ->first();
        
        if ($receiverConversation) {
            $receiverConversation->increment('unread_count');
            $receiverConversation->update(['last_time_message' => now()]);
        } else {
            Conversation::create([
                'user_id' => $receiverId,
                'other_user_id' => $senderId,
                'last_time_message' => now(),
                'unread_count' => 1,
            ]);
        }
    }
    
    /**
     * Mark messages as read for a conversation
     */
    private function markMessagesAsRead($conversation)
    {
        Message::where('sender_id', $conversation->other_user_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Reset unread count
        $conversation->resetUnread();
    }
    
    /**
     * Delete a conversation and its messages
     */
    public function destroy($conversationId)
    {
        $conversation = Conversation::where('id', $conversationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        
        // Delete all messages in this conversation
        Message::where(function($query) use ($conversation) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $conversation->other_user_id);
        })->orWhere(function($query) use ($conversation) {
            $query->where('sender_id', $conversation->other_user_id)
                  ->where('receiver_id', Auth::id());
        })->delete();
        
        // Delete both sides of the conversation
        Conversation::where('user_id', Auth::id())
            ->where('other_user_id', $conversation->other_user_id)
            ->delete();
        
        Conversation::where('user_id', $conversation->other_user_id)
            ->where('other_user_id', Auth::id())
            ->delete();
        
        return redirect()->route('chat.chat_index')->with('success', 'Conversation deleted');
    }
    public function fetchMessages(Request $request, $chatId)
    {
        $afterId = $request->query('after');

        $query = Message::where('chat_id', $chatId)
                        ->orderBy('id', 'asc');

        if ($afterId) {
            $query->where('id', '>', $afterId);
        }

        $messages = $query->get();

        return response()->json($messages);
    }


}