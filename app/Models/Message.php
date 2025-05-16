<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'attachment',
        'attachment_type',
        'is_read'
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    /**
     * Get the sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    
    /**
     * Get the receiver of the message
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    
    /**
     * Scope a query to only include unread messages
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
    
    /**
     * Mark the message as read
     */
    public function markAsRead()
    {
        $this->update(['is_read' => true]);
    }
    
    /**
     * Check if the message has an attachment
     */
    public function hasAttachment()
    {
        return !is_null($this->attachment);
    }
    
    /**
     * Check if the attachment is an image
     */
    public function isImage()
    {
        return $this->attachment_type === 'image';
    }
    
    /**
     * Get the attachment URL
     */
    public function getAttachmentUrl()
    {
        if ($this->hasAttachment()) {
            return asset('storage/' . $this->attachment);
        }
        
        return null;
    }
}