<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskReview extends Model
{
    protected $fillable = ['task_id', 'rating', 'review'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}

