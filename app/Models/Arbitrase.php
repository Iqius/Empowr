<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Arbitrase extends Model
{
    protected $fillable = ['task_id', 'reason', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}

