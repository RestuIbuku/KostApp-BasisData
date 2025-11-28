<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'booking_id';
    public $timestamps = false;

    protected $fillable = [
        'pencari_id',
        'kamar_id',
        'tgl_mulai_sewa',
        'tgl_selesai_sewa',
        'total_harga',
        'status_booking',
        'created_at'
    ];

    public function pencari()
    {
        return $this->belongsTo(User::class, 'pencari_id', 'user_id');
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'kamar_id');
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'booking_id', 'booking_id');
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class, 'booking_id', 'booking_id');
    }
}
