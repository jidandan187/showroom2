<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\VisitorSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityTracker
{
    public static function track(
        Request $request,
        string $event,
        ?int $mobilId = null,
        ?string $searchKeyword = null,
        ?string $metadata = null
    ): void {

        $sessionId = $request->session()->getId();

        $visitor = VisitorSession::firstOrCreate(

            [
                'session_id' => $sessionId,
            ],

            [
                'user_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => substr(
                    $request->userAgent() ?? '',
                    0,
                    255
                ),
                'landing_page' => $request->path(),
                'first_seen_at' => now(),
                'last_seen_at' => now(),
            ]

        );

        $visitor->update([

            'user_id' => Auth::id(),
            'last_seen_at' => now(),

        ]);

        ActivityLog::create([

            'visitor_session_id' => $visitor->id,

            'user_id' => Auth::id(),

            'mobil_id' => $mobilId,

            'event' => $event,

            'page' => $request->path(),

            'search_keyword' => $searchKeyword,

            'metadata' => $metadata,

        ]);
    }
}