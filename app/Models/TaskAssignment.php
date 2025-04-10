<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    protected $fillable = ['task_id', 'worker_profile_id', 'assigned_at'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function profile()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_profile_id');
    }
}

