<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerProfile extends Model
{
    use HasFactory;

    protected $table = 'worker_profiles';

    protected $fillable = [
        'user_id',
        'tingkat_keahlian',
        'keahlian',
        'empowr_label',
        'empowr_affiliate',
        'cv',
        'pengalaman_kerja',
        'pendidikan',
        'status_aktif',
        'tanggal_diperbarui',
        'keahlian_affiliate',
        'identity_photo',
        'selfie_with_id',
        'affiliated_since',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
