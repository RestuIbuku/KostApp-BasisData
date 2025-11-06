<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'no_hp',
        'role'
    ];

    protected $hidden = [
        'password',
    ];
}
