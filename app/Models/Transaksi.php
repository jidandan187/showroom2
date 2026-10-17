<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [

        'invoice',
        'user_id',
        'mobil_id',
        'metode_pembayaran',
        'dp',
        'tenor',
        'cicilan_per_bulan',
        'total_harga',
        'sisa_pembayaran',
        'status'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

public function detailTransaksi()
{
    return $this->hasMany(
        DetailTransaksi::class
    );
}
}