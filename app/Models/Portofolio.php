<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portfolios';

    protected $fillable = [
        'worker_id',
        'title',
        'description',
        'duration',
    ];

    public function profile()
    {
        return $this->belongsTo(WorkerProfile::class, 'worker_id');
    }

    public function images()
    {
        return $this->hasMany(PortofolioImage::class, 'portfolio_id');
    }
}
