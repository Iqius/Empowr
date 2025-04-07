<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertifikasi extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi';

    protected $fillable = [
        'worker_id',
        'title',
    ];

    public function profile()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }

    public function images()
    {
        return $this->hasMany(SertifikasiImage::class, 'sertifikasi_id');
    }
}

