<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    protected $table = 'kamar';
    protected $primaryKey = 'kamar_id';
    public $timestamps = false;

    protected $fillable = [
        'kos_id',
        'nama_kamar',
        'harga_per_malam',
        'status_ketersediaan',
        'ukuran_kamar'
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class, 'kos_id', 'kos_id');
    }

    public function fotos()
    {
        return $this->hasMany(FotoKamar::class, 'kamar_id', 'kamar_id');
    }

    public function fotoKamar()
    {
        return $this->hasMany(FotoKamar::class, 'kamar_id', 'kamar_id');
    }

    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'kamar_fasilitas', 'kamar_id', 'fasilitas_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'kamar_id', 'kamar_id');
    }
}
