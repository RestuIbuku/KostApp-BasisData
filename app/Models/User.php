<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use App\Models\Kos;
use App\Models\Booking;
use App\Models\Ulasan;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';
    public $timestamps = false; // Disable timestamps karena tabel hanya punya created_at

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password_hash',
        'password',
        'no_hp',
        'role'
    ];

    protected $hidden = [
        'password_hash',
    ];

    /**
     * Hash password into password_hash when set via $user->password = '...'
     */
    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password_hash'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    /**
     * Make Laravel Auth use password_hash column
     */
    public function getAuthPassword()
    {
        return $this->password_hash;
    }

    // Relationships
    public function kos()
    {
        return $this->hasMany(Kos::class, 'pemilik_id', 'user_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'pencari_id', 'user_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'pencari_id', 'user_id');
    }
}
