<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $primaryKey = 'fasilitas_id';
    public $timestamps = false;

    protected $fillable = [
        'nama_fasilitas',
        'tipe'
    ];

    public function kos()
    {
        return $this->belongsToMany(Kos::class, 'kos_fasilitas', 'fasilitas_id', 'kos_id');
    }

    public function kamar()
    {
        return $this->belongsToMany(Kamar::class, 'kamar_fasilitas', 'fasilitas_id', 'kamar_id');
    }
}
