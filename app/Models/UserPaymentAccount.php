<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPaymentAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'account_type',

        'ewallet_provider',
        'wallet_number',
        'ewallet_account_name',
        
        'bank_name',
        'account_number',
        'bank_account_name',
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
