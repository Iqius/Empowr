<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioImage extends Model
{
    use HasFactory;

    protected $table = 'portofolio_images';

    protected $fillable = [
        'portofolio_id',
        'image',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portofolio::class, 'portofolio_id');
    }
}

