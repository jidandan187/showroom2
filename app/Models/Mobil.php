<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobil';

    protected $fillable = [
        'nama_mobil',
        'merk',
        'tahun',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
        'status',
        'transmisi',
        'bahan_bakar',
        'warna',
    ];

    public function images()
    {
        return $this->hasMany(MobilImage::class);
    }

    public function colors()
    {
        return $this->hasMany(MobilColor::class);
    }

    public function detailTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

    public function isReady(): bool
    {
        return ($this->status ?? 'ready') === 'ready';
    }
}