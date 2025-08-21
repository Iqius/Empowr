<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskApplication extends Model
{
    protected $fillable = ['task_id', 'profile_id', 'catatan','bidPrice', 'status', 'harga_pajak_affiliate','applied_at', 'affiliated'];
    public $timestamps = false;


    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    public function profile()
{
    return $this->belongsTo(\App\Models\WorkerProfile::class, 'profile_id');
}


    public function worker(): BelongsTo
    {
        return $this->belongsTo(WorkerProfile::class, 'profile_id');
    }
}

