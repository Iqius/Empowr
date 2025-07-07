<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WorkerAffiliated extends Model
{
    use HasFactory;

    protected $table = 'worker_verification_affiliations';

    protected $fillable = [
        'profile_id',
        'identity_photo',
        'selfie_with_id',
        'link_meet',
        'jadwal_interview',
        'keahlian_affiliate',
        'status',
        'status_decision',
    ];

    public function workerProfile()
    {
        return $this->belongsTo(WorkerProfile::class, 'profile_id', 'id');
    }


    public function logs()
    {
        return $this->hasMany(workerAffiliatedLogs::class, 'affiliation_id', 'id');
    }
}
