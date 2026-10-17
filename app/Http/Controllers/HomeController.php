<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Services\ActivityTracker;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        ActivityTracker::track($request, 'home_view');

        $featured = Mobil::query()
            ->where('status', '!=', 'sold')
            ->latest()
            ->take(12)
            ->get();

        $brands = Mobil::query()
            ->selectRaw('merk, COUNT(*) as total')
            ->where('status', '!=', 'sold')
            ->groupBy('merk')
            ->orderBy('merk')
            ->get();

        return view('user.home', compact('featured', 'brands'));
    }

    public function detail(Request $request, int $id)
    {
        $mobil = Mobil::with(['images', 'colors'])->findOrFail($id);

        ActivityTracker::track($request, 'mobil_view', $mobil->id);

        $similar = Mobil::query()
            ->where('merk', $mobil->merk)
            ->whereKeyNot($mobil->id)
            ->where('status', '!=', 'sold')
            ->latest()
            ->take(4)
            ->get();

        return view('user.detail', compact('mobil', 'similar'));
    }

    public function whatsapp(Request $request, int $id)
    {
        $request->validate([
            'color_id' => ['nullable', 'integer'],
        ]);

        $mobil = Mobil::with('colors')->findOrFail($id);

        if (($mobil->status ?? 'ready') !== 'ready') {
            return back()->with('error', 'Unit ini saat ini tidak tersedia.');
        }

        $availableColors = $mobil->colors
            ->where('tersedia', true)
            ->where('stok', '>', 0);
        $hasColorData = $mobil->colors->isNotEmpty();
        $selectedColor = null;

        if ($hasColorData) {
            $colorId = $request->input('color_id')
                ?? $availableColors->first()?->id;

            $selectedColor = $mobil->colors()
                ->whereKey($colorId)
                ->where('tersedia', true)
                ->where('stok', '>', 0)
                ->first();

            if (!$selectedColor) {
                return back()->with('error', 'Warna yang dipilih sudah tidak tersedia.');
            }
        } elseif ((int) $mobil->stok <= 0) {
            return back()->with('error', 'Unit ini saat ini tidak tersedia.');
        }

        ActivityTracker::track($request, 'whatsapp_click', $mobil->id);

        $warna = $selectedColor
            ? $selectedColor->nama_warna
            : ($mobil->warna ?: 'Belum ditentukan');

        $message = "Halo Thomy Showroom 👋\n\n"
            . "Saya tertarik dengan mobil berikut:\n\n"
            . "🚗 " . $mobil->nama_mobil . "\n"
            . "🏷️ Merk: " . $mobil->merk . "\n"
            . "📅 Tahun: " . $mobil->tahun . "\n"
            . "⚙️ Transmisi: " . ($mobil->transmisi ?: '-') . "\n"
            . "⛽ Bahan Bakar: " . ($mobil->bahan_bakar ?: '-') . "\n"
            . "🎨 Warna yang diminati: " . $warna . "\n"
            . "💰 Harga: Rp " . number_format($mobil->harga, 0, ',', '.')
            . "\n\nMohon informasi ketersediaan unit dan penawaran terbaiknya. Terima kasih 🙏";

        return redirect()->away('https://wa.me/' . config('services.whatsapp.number') . '?text=' . urlencode($message));
    }
}
