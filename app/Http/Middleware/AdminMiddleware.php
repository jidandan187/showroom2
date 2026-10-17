<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $admin = Auth::guard('admin')->user();

        if (! $admin) {
            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Silakan login sebagai admin terlebih dahulu.'
                );
        }

        if ($admin->role !== 'admin') {
            Auth::guard('admin')->logout();

            return redirect()
                ->route('admin.login')
                ->with(
                    'error',
                    'Akun ini tidak memiliki akses admin.'
                );
        }

        return $next($request);
    }
}
