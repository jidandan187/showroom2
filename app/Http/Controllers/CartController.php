<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Mobil;
use App\Services\ActivityTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['mobil', 'color'])
            ->where('user_id', Auth::guard('web')->id())
            ->latest()
            ->get();

        $total = $carts->sum(fn ($cart) => ($cart->mobil?->harga ?? 0) * $cart->qty);

        return view('cart.index', compact('carts', 'total'));
    }

    public function add(Request $request, int $id)
    {
        $mobil = Mobil::with('colors')->whereKey($id)->first();

        if (!$mobil || ($mobil->status ?? 'ready') !== 'ready') {
            return back()->with('error', 'Unit ini sudah tidak tersedia untuk ditambahkan ke Mobil Pilihan.');
        }

        $request->validate([
            'color_id' => [
                'nullable',
                'integer',
                Rule::exists('mobil_colors', 'id')->where(
                    fn ($query) => $query->where('mobil_id', $mobil->id)
                ),
            ],
        ]);

        // Jika mobil mempunyai data warna, ketersediaan unit ditentukan oleh stok warna.
        // Ini mencegah status 'ready' di tabel mobil bertentangan dengan warna yang sebenarnya habis.
        $availableColors = $mobil->colors
            ->where('tersedia', true)
            ->where('stok', '>', 0);
        $hasColorData = $mobil->colors->isNotEmpty();
        $color = null;

        if ($hasColorData) {
            $colorId = $request->input('color_id')
                ?? $availableColors->first()?->id;

            $color = $mobil->colors()
                ->whereKey($colorId)
                ->where('tersedia', true)
                ->where('stok', '>', 0)
                ->first();

            if (!$color) {
                return back()->with('error', 'Warna yang dipilih sudah tidak tersedia. Silakan pilih warna lain yang masih memiliki stok.');
            }
        } elseif ((int) $mobil->stok <= 0) {
            return back()->with('error', 'Unit ini sudah tidak tersedia untuk ditambahkan ke Mobil Pilihan.');
        }

        $cart = Cart::query()
            ->where('user_id', Auth::guard('web')->id())
            ->where('mobil_id', $mobil->id)
            ->when(
                $color,
                fn ($query) => $query->where('mobil_color_id', $color->id),
                fn ($query) => $query->whereNull('mobil_color_id')
            )
            ->first();

        if ($cart) {
            return redirect()->route('cart.index')->with('info', 'Mobil ini sudah ada di Mobil Pilihan kamu.');
        }

        Cart::create([
            'user_id' => Auth::guard('web')->id(),
            'mobil_id' => $mobil->id,
            'mobil_color_id' => $color?->id,
            'qty' => 1,
        ]);

        ActivityTracker::track(
            $request,
            'cart_add',
            $mobil->id,
            null,
            $color?->nama_warna ?? $mobil->warna
        );

        return redirect()->route('cart.index')->with(
            'success',
            $mobil->nama_mobil . ($color ? ' warna ' . $color->nama_warna : '') . ' berhasil ditambahkan ke Mobil Pilihan.'
        );
    }

    public function remove(int $id)
    {
        $cart = Cart::whereKey($id)->where('user_id', Auth::guard('web')->id())->firstOrFail();
        $cart->delete();

        return back()->with('success', 'Mobil berhasil dihapus dari Mobil Pilihan.');
    }
}
