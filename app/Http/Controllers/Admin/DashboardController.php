<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Cart;
use App\Models\Mobil;
use App\Models\User;
use App\Models\VisitorSession;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK MOBIL
        |--------------------------------------------------------------------------
        */

        $totalMobil = Mobil::count();

        $mobilReady = Mobil::where(
            'status',
            'ready'
        )->count();

        $mobilBooking = Mobil::where(
            'status',
            'booking'
        )->count();

        $mobilSold = Mobil::where(
            'status',
            'sold'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | USER DAN PENGUNJUNG
        |--------------------------------------------------------------------------
        */

        $totalUser = User::count();

        $totalVisitor = VisitorSession::count();

        $visitorToday = VisitorSession::whereDate(
            'last_seen_at',
            today()
        )->count();


        /*
        |--------------------------------------------------------------------------
        | MINAT PEMBELI
        |--------------------------------------------------------------------------
        */

        $totalWhatsapp = ActivityLog::where(
            'event',
            'whatsapp_click'
        )->count();

        $totalCartInterest = ActivityLog::where(
            'event',
            'cart_add'
        )->count();

        $activeCartItems = Cart::count();


        /*
        |--------------------------------------------------------------------------
        | MOBIL PALING BANYAK DILIHAT
        |--------------------------------------------------------------------------
        */

        $popularCars = ActivityLog::query()

            ->selectRaw(
                'mobil_id, COUNT(*) as total_views'
            )

            ->where(
                'event',
                'mobil_view'
            )

            ->whereNotNull(
                'mobil_id'
            )

            ->groupBy(
                'mobil_id'
            )

            ->orderByDesc(
                'total_views'
            )

            ->with(
                'mobil'
            )

            ->take(5)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | MOBIL PALING DIMINATI
        |--------------------------------------------------------------------------
        |
        | Menggabungkan:
        |
        | - Mobil yang masuk Mobil Pilihan
        | - Klik WhatsApp
        |
        */

        $buyerInterest = ActivityLog::query()

            ->selectRaw(
                "
                mobil_id,

                SUM(
                    CASE
                        WHEN event = 'cart_add'
                        THEN 1
                        ELSE 0
                    END
                ) as cart_count,

                SUM(
                    CASE
                        WHEN event = 'whatsapp_click'
                        THEN 1
                        ELSE 0
                    END
                ) as whatsapp_count,

                SUM(
                    CASE
                        WHEN event IN (
                            'cart_add',
                            'whatsapp_click'
                        )
                        THEN 1
                        ELSE 0
                    END
                ) as total_interest
                "
            )

            ->whereIn(
                'event',
                [
                    'cart_add',
                    'whatsapp_click'
                ]
            )

            ->whereNotNull(
                'mobil_id'
            )

            ->groupBy(
                'mobil_id'
            )

            ->orderByDesc(
                'total_interest'
            )

            ->with(
                'mobil'
            )

            ->take(5)

            ->get();


        /*
        |--------------------------------------------------------------------------
        | AKTIVITAS TERBARU
        |--------------------------------------------------------------------------
        */

        $recentTransactions = Transaksi::query()
            ->with(['user', 'detailTransaksi.mobil'])
            ->latest()
            ->take(5)
            ->get();


        $activities = ActivityLog::query()

            ->latest()

            ->with([
                'mobil',
                'visitor',
                'user'
            ])

            ->take(12)

            ->get();


        return view(
            'admin.dashboard',
            compact(
                'totalMobil',
                'mobilReady',
                'mobilBooking',
                'mobilSold',
                'totalUser',
                'totalVisitor',
                'visitorToday',
                'totalWhatsapp',
                'totalCartInterest',
                'activeCartItems',
                'popularCars',
                'buyerInterest',
                'activities',
                'recentTransactions'
            )
        );
    }
}