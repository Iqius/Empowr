<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'task_id',
        'worker_id',
        'client_id',
        'amount',
        'status',
        'type',
        'payment_method',
        'proof_transfer',
        'withdraw_method'
    ];


    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    // Relasi opsional
    public function worker()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    
}
