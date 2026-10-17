<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(): View|RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.admin-login');
    }

    public function store(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($credentials['email']) . '|' . $request->ip() . '|admin');

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);

            throw ValidationException::withMessages([
                'email' => 'Terlalu banyak percobaan login. Coba lagi dalam ' . $seconds . ' detik.',
            ]);
        }

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($throttleKey, 60);
            throw ValidationException::withMessages([
                'email' => 'Email atau password admin salah.',
            ]);
        }

        RateLimiter::clear($throttleKey);

        if ($user->role !== 'admin') {
            throw ValidationException::withMessages([
                'email' => 'Akun ini tidak memiliki akses admin.',
            ]);
        }

        Auth::guard('admin')->login(
            $user,
            $request->boolean('remember')
        );

        // Regenerasi ID tanpa menghapus guard web.
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        // Jangan invalidate session karena user guard harus tetap aman.
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Anda berhasil logout dari Admin Panel.');
    }
}
