<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    public $timestamps = false; // ← tambahkan ini

    protected $fillable = [
        'kode_containers',
        'latitude',
        'longitude',
        'nama_lokasi',
        'id_kecamatan',
        'id_kelurahan',
        'kapasitas',
        'persen',
        'baterai',
        'status'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(
            Kecamatan::class,
            'id_kecamatan',
            'id_kecamatan'
        );
    }

    public function kelurahan()
    {
        return $this->belongsTo(
            Kelurahan::class,
            'id_kelurahan',
            'id_kelurahan'
        );
    }
}