<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kos extends Model
{
    protected $table = 'kos';
    protected $primaryKey = 'kos_id';
    public $timestamps = false; // Disable timestamps karena tabel hanya punya created_at

    protected $fillable = [
        'pemilik_id',
        'nama_kos',
        'alamat',
        'deskripsi',
        'foto',
        'tipe_kos',
        'latitude',
        'longitude',
        'jumlah_kamar_kosong',
        'jumlah_kamar_total'
    ];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id', 'user_id');
    }

    public function kamar()
    {
        return $this->hasMany(Kamar::class, 'kos_id', 'kos_id');
    }

    public function fasilitasUmum()
    {
        return $this->belongsToMany(Fasilitas::class, 'kos_fasilitas', 'kos_id', 'fasilitas_id');
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'kos_id', 'kos_id');
    }
}
