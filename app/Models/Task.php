<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $table = 'task';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'client_id',
        'profile_id',
        'title',
        'description',
        'price',
        'status',
        'revisions',
        'taskType',
        'taskModel',
        'job_file',
        'start_date',
        'category',
        'location',
        'qualification',
        'rules',
        'deadline',
        'deadline_promotion'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(WorkerProfile::class, 'profile_id');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(TaskApplication::class, 'task_id');
    }

    public function assignment()
    {
        return $this->hasOne(TaskAssignment::class, 'task_id');
    }

    public function review()
    {
        return $this->hasOne(TaskReview::class, 'task_id');
    }

    public function escrow()
    {
        return $this->hasOne(EscrowPayment::class, 'task_id');
    }

    public function arbitrase()
    {
        return $this->hasOne(Arbitrase::class, 'task_id');
    }
}

