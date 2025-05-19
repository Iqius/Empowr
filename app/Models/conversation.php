<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Conversation extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'other_user_id',
        'last_time_message',
        'unread_count'
    ];
    
    protected $casts = [
        'last_time_message' => 'datetime',
    ];
    
    /**
     * Get the user that owns the conversation
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the other user in the conversation
     */
    public function otherUser()
    {
        return $this->belongsTo(User::class, 'other_user_id');
    }
    
    /**
     * Get the messages for this conversation
     */
    public function messages()
    {
        // This gets messages where the current user is either sender or receiver
        // and the other person is either receiver or sender respectively
        return Message::where(function($query) {
            $query->where('sender_id', $this->user_id)
                  ->where('receiver_id', $this->other_user_id);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->other_user_id)
                  ->where('receiver_id', $this->user_id);
        })->orderBy('created_at', 'asc');
    }
    
    /**
     * Get the latest message from this conversation
     */
    public function latestMessage()
    {
        return $this->messages()->get()->last();
    }
    
    /**
     * Increment the unread count
     */
    public function incrementUnread()
    {
        $this->increment('unread_count');
    }
    
    /**
     * Reset the unread count to zero
     */
    public function resetUnread()
    {
        $this->update(['unread_count' => 0]);
    }
    
    /**
     * Update the last message time
     */
    public function touch($attribute = null)
    {
        $this->update(['last_time_message' => now()]);
        parent::touch($attribute);
    }
      public function timeRemaining()
    {
        if (!$this->expiration_time) {
            return null;
        }

        $now = Carbon::now();
        return $now->diffForHumans(Carbon::parse($this->expiration_time), true);
    }
}