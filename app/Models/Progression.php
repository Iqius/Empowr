<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Progression extends Model
{
    use HasFactory;

    protected $table = 'task_progression';

    protected $fillable = [
        'task_id',
        'path_file',
        'status_upload',
        'status_approve',
        'note',
        'date_upload',
        'date_approve',
        'progression_ke',
        'action_by_client',
        'action_by_worker',
    ];

    protected $casts = [
        'date_upload' => 'datetime',
        'date_approve' => 'datetime',
    ];

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'action_by_client');
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by_worker');
    }
}
