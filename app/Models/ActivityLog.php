<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'visitor_session_id',
        'user_id',
        'mobil_id',
        'event',
        'page',
        'search_keyword',
        'metadata',
    ];


    public function mobil()
    {
        return $this->belongsTo(
            Mobil::class
        );
    }


    public function visitor()
    {
        return $this->belongsTo(
            VisitorSession::class,
            'visitor_session_id'
        );
    }


    public function user()
    {
        return $this->belongsTo(
            User::class
        );
    }
}