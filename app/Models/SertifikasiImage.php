<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SertifikasiImage extends Model
{
    use HasFactory;

    protected $table = 'sertifikasi_images';

    protected $fillable = [
        'sertifikasi_id',
        'image',
    ];

    public function sertifikasi()
    {
        return $this->belongsTo(Sertifikasi::class, 'sertifikasi_id');
    }
}

