<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Kos extends Model
{
    protected $table = 'kos';
    protected $primaryKey = 'kos_id';

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
}
