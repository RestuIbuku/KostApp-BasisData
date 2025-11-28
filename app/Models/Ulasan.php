<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'ulasan_id';
    public $timestamps = false;

    protected $fillable = [
        'kos_id',
        'pencari_id',
        'booking_id',
        'rating',
        'komentar',
        'tgl_ulasan'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id', 'kos_id');
    }

    public function pencari()
    {
        return $this->belongsTo(User::class, 'pencari_id', 'user_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'booking_id');
    }
}
