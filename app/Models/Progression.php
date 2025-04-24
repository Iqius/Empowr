<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
