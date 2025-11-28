<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FotoKamar extends Model
{
    protected $table = 'foto_kamar';
    protected $primaryKey = 'foto_id';
    public $timestamps = false;

    protected $fillable = [
        'kamar_id',
        'url_foto',
        'deskripsi_foto'
    ];

    public function kamar()
    {
        return $this->belongsTo(Kamar::class, 'kamar_id', 'kamar_id');
    }
}
