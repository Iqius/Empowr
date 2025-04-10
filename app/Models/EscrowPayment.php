<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscrowPayment extends Model
{
    protected $fillable = ['task_id', 'amount', 'status'];

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}

