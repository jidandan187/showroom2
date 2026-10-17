<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorSession extends Model
{
    protected $fillable = [

        'session_id',
        'user_id',
        'ip_address',
        'user_agent',
        'landing_page',
        'first_seen_at',
        'last_seen_at',

    ];

    protected function casts(): array
    {
        return [

            'first_seen_at' => 'datetime',
            'last_seen_at' => 'datetime',

        ];
    }

    public function activities()
    {
        return $this->hasMany(ActivityLog::class);
    }
}