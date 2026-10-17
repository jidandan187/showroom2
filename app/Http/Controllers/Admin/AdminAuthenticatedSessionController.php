<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Validation\ValidationException;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;

class AdminAuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('admin.auth.login');
    }


    public function store(
        Request $request
    ): RedirectResponse {

        $credentials = $request->validate([

            'email' => [

                'required',

                'email',

            ],

            'password' => [

                'required',

                'string',

            ],

        ]);


        $remember = $request->boolean(
            'remember'
        );


        $credentials['role'] = 'admin';


        if (!Auth::guard('admin')->attempt(
            $credentials,
            $remember
        )) {

            throw ValidationException::withMessages([

                'email' => [

                    'Email atau password admin salah.'
                ],

            ]);

        }


        $request->session()->regenerate();


        return redirect()
            ->intended(
                route('admin.dashboard')
            );

    }


    public function destroy(
        Request $request
    ): RedirectResponse {

        Auth::guard('admin')->logout();


        /*
        |----------------------------------------------
        | Jangan gunakan:
        |
        | $request->session()->invalidate();
        |
        | Karena user login pada guard web
        | harus tetap aman.
        |----------------------------------------------
        */


        $request->session()
            ->regenerateToken();


        return redirect()
            ->route('admin.login')
            ->with(
                'success',
                'Anda berhasil logout dari admin.'
            );

    }
}