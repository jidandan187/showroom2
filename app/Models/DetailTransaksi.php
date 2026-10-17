<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = [

        'transaksi_id',
        'mobil_id',
        'qty',
        'harga',
        'subtotal'

    ];

    public function transaksi()
    {
        return $this->belongsTo(
            Transaksi::class
        );
    }

    public function mobil()
    {
        return $this->belongsTo(
            Mobil::class
        );
    }
}