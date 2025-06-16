<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\UserPaymentAccount;
use App\Models\Session;
// use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // use HasUuids;

    // protected $keyType = 'int';
    // public $incrementing = false; // Karena UUID bukan angka otomatis

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'role',
        'tanggal_bergabung',
        'nomor_telepon',
        'password',
        'linkedin',
        'profile_image',
        'alamat',  // Tambahkan ini
        'negara',  // Tambahkan ini
        // 'bio',     // Tambahkan ini
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function paymentAccount()
    {
        return $this->hasOne(UserPaymentAccount::class, 'user_id');
    }

    public function keahlian()
    {
        return $this->hasOne(WorkerProfile::class, 'user_id');
    }

    public function workerProfile()
    {
        return $this->hasOne(WorkerProfile::class, 'user_id');
    }

    public function getNameAttribute()
    {
        return $this->username;
    }

    public function isOnline()
    {
        return false; // Selalu kembalikan false
    }

    public function ewallet()
    {
        return $this->hasOne(Ewallet::class, 'user_id');
    }


    public function withdraws()
    {
        return $this->hasMany(Transaction::class, 'client_id')->where('type', 'payout');
    }

    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id');
    }
}
