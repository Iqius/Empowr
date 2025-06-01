<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class workerAffiliatedLogs extends Model
{
    use HasFactory;

    protected $table = 'worker_verification_affiliation_logs';

    protected $fillable = [
        'affiliation_id',
        'status_decision',
        'status',
        'action_admin'
    ];

    public function affiliation()
    {
        return $this->belongsTo(WorkerVerificationAffiliation::class, 'affiliation_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'action_admin', 'id');
    }

}
