<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    protected $table = 'ewallet';
    protected $fillable = ['user_id', 'balance'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
