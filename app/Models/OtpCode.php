<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = ['email', 'otp', 'expires_at'];
    public $timestamps = true;

    protected $dates = ['expires_at'];
}

