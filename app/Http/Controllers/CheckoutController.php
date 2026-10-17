<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $data = $request->validate([
            'metode_pembayaran' => ['required', 'in:cash,kredit'],
            'dp' => ['nullable', 'numeric', 'min:0'],
            'tenor' => ['required_if:metode_pembayaran,kredit', 'nullable', 'integer', 'min:1', 'max:120'],
        ]);

        $userId = Auth::guard('web')->id();
        $carts = Cart::with(['mobil', 'color'])
            ->where('user_id', $userId)
            ->get();

        if ($carts->isEmpty()) {
            return back()->with('error', 'Mobil Pilihan masih kosong.');
        }

        // Cart is a shortlist, not a reservation. Re-check availability before creating the summary.
        foreach ($carts as $cart) {
            $mobil = $cart->mobil;
            if (! $mobil || ($mobil->status ?? 'ready') !== 'ready') {
                throw ValidationException::withMessages([
                    'checkout' => 'Salah satu mobil pilihan sudah tidak tersedia. Silakan periksa Mobil Pilihan kembali.',
                ]);
            }

            if ($cart->color) {
                if (! $cart->color->tersedia || (int) $cart->color->stok < (int) $cart->qty) {
                    throw ValidationException::withMessages([
                        'checkout' => 'Warna ' . $cart->color->nama_warna . ' untuk ' . $mobil->nama_mobil . ' sudah tidak tersedia.',
                    ]);
                }
            } elseif ((int) $mobil->stok < (int) $cart->qty) {
                throw ValidationException::withMessages([
                    'checkout' => 'Stok ' . $mobil->nama_mobil . ' sudah tidak mencukupi.',
                ]);
            }
        }

        $total = $carts->sum(fn ($cart) => (float) $cart->mobil->harga * (int) $cart->qty);
        $dp = (float) ($data['dp'] ?? 0);

        if ($data['metode_pembayaran'] === 'cash') {
            $dp = 0;
        } elseif ($dp <= 0) {
            throw ValidationException::withMessages([
                'dp' => 'DP wajib diisi untuk pembayaran kredit.',
            ]);
        } elseif ($dp > $total) {
            throw ValidationException::withMessages([
                'dp' => 'DP tidak boleh lebih besar dari total estimasi harga.',
            ]);
        }

        $tenor = $data['metode_pembayaran'] === 'kredit' ? (int) $data['tenor'] : null;
        $sisa = max(0, $total - $dp);
        $cicilan = $tenor ? $sisa / $tenor : null;

        $transaksi = DB::transaction(function () use ($userId, $carts, $data, $total, $dp, $sisa, $tenor, $cicilan) {
            $invoice = 'INV-' . now()->format('YmdHis') . '-' . strtoupper(bin2hex(random_bytes(3)));

            $transaksi = Transaksi::create([
                'invoice' => $invoice,
                'user_id' => $userId,
                'total_harga' => $total,
                'metode_pembayaran' => $data['metode_pembayaran'],
                'dp' => $dp ?: null,
                'tenor' => $tenor,
                'cicilan_per_bulan' => $cicilan,
                'sisa_pembayaran' => $sisa,
                'status' => 'pending',
            ]);

            foreach ($carts as $cart) {
                $harga = (float) $cart->mobil->harga;
                $qty = (int) $cart->qty;

                $transaksi->detailTransaksi()->create([
                    'mobil_id' => $cart->mobil_id,
                    'qty' => $qty,
                    'harga' => $harga,
                    'subtotal' => $harga * $qty,
                ]);
            }

            Cart::where('user_id', $userId)->delete();

            return $transaksi;
        });

        return redirect()->route('invoice.cetak', $transaksi->id);
    }
}
