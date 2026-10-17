<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $table = 'cart';

    protected $fillable = [
        'user_id',
        'mobil_id',
        'mobil_color_id',
        'qty',
    ];

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function color()
    {
        return $this->belongsTo(
            MobilColor::class,
            'mobil_color_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}