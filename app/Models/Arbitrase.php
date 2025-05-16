<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arbitrase extends Model
{
    use HasFactory;

    protected $table = 'arbitrase';

    protected $fillable = [
        'worker_id',
        'client_id',
        'task_id',
        'status',
        'reason',
        'created_at',
    ];

    public $timestamps = false;

    // Relasi ke User sebagai Worker
    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    // Relasi ke User sebagai Client
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relasi ke Task
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
