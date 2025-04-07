<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortofolioImage extends Model
{
    use HasFactory;

    protected $table = 'portfolio_images';

    protected $fillable = [
        'portfolio_id',
        'image',
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portofolio::class, 'portfolio_id');
    }
}

