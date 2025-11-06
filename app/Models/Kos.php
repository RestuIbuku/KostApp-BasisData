<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kos extends Model
{
    protected $table = 'kos';
    protected $primaryKey = 'kos_id';

    protected $fillable = [
        'pemilik_id',
        'nama_kos',
        'alamat',
        'deskripsi',
        'tipe_kos',
        'latitude',
        'longitude'
    ];

    public function pemilik()
    {
        return $this->belongsTo(User::class, 'pemilik_id', 'user_id');
    }
}
