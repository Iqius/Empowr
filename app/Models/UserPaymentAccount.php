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
        'wallet_number',
        'ewallet_account_name',
        'bank_name',
        'account_number',
        'bank_account_name',
        'ewallet_provider',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
