<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobilColor extends Model
{
    protected $fillable = [
        'mobil_id',
        'nama_warna',
        'kode_warna',
        'tersedia',
        'stok',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }
}