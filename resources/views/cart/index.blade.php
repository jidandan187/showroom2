@extends('layouts.app')

@section('content')

<section class="cart-page">
    <div class="container">

        <div class="cart-header">

            <div>
                <div class="section-kicker">
                    MOBIL PILIHAN SAYA
                </div>

                <h1 class="cart-title mb-1">
                    Mobil Pilihan Saya
                </h1>

                <p class="text-secondary mb-0">
                    Semua mobil yang Anda simpan sebelum berkonsultasi dengan sales.
                </p>
            </div>

            <a
                href="{{ route('home') }}#katalog"
                class="btn btn-outline-dark rounded-3 fw-bold"
            >
                Tambah Pilihan
            </a>

        </div>


        @if($carts->isEmpty())

            <div class="empty-state">

                <div class="fs-1 text-warning mb-3">
                    <i class="fa-regular fa-heart"></i>
                </div>

                <h3 class="fw-bold">
                    Belum ada mobil pilihan
                </h3>

                <p class="text-secondary">
                    Jelajahi katalog dan simpan mobil yang ingin Anda pertimbangkan.
                </p>

                <a
                    href="{{ route('home') }}#katalog"
                    class="btn btn-gold"
                >
                    Lihat Katalog Mobil
                </a>

            </div>

        @else

            <div class="cart-layout">

                <div class="cart-list">

                    @foreach($carts as $cart)

                        @if($cart->mobil)

                            @php
                                $warnaPilihan =
                                    $cart->color?->nama_warna
                                    ?? $cart->mobil->warna
                                    ?? '-';
                            @endphp

                            <article class="cart-item">

                                <img
                                    src="{{ asset('uploads/mobil/' . $cart->mobil->gambar) }}"
                                    class="cart-image"
                                    alt="{{ $cart->mobil->nama_mobil }}"
                                >

                                <div class="cart-item-content">

                                    <div class="cart-item-top">

                                        <div>

                                            <div class="cart-brand">
                                                {{ $cart->mobil->merk }}
                                            </div>

                                            <h2 class="cart-car-name">
                                                {{ $cart->mobil->nama_mobil }}
                                            </h2>

                                        </div>

                                        <span class="ready-badge">

                                            {{ ucfirst($cart->mobil->status ?: 'ready') }}

                                        </span>

                                    </div>


                                    <div class="cart-spec-list">

                                        <span>
                                            <i class="fa-solid fa-calendar me-1"></i>
                                            {{ $cart->mobil->tahun }}
                                        </span>

                                        <span>
                                            <i class="fa-solid fa-gear me-1"></i>
                                            {{ $cart->mobil->transmisi ?: '-' }}
                                        </span>

                                        <span>
                                            <i class="fa-solid fa-gas-pump me-1"></i>
                                            {{ $cart->mobil->bahan_bakar ?: '-' }}
                                        </span>

                                        <span>
                                            <i class="fa-solid fa-palette me-1"></i>
                                            {{ $warnaPilihan }}
                                        </span>

                                    </div>


                                    <div class="cart-item-bottom">

                                        <div class="cart-price">

                                            Rp {{
                                                number_format(
                                                    $cart->mobil->harga,
                                                    0,
                                                    ',',
                                                    '.'
                                                )
                                            }}

                                        </div>


                                        <div class="cart-actions">

                                            <a
                                                href="{{ route('mobil.detail', $cart->mobil->id) }}"
                                                class="btn btn-light border"
                                            >

                                                <i class="fa-regular fa-eye me-1"></i>

                                                Detail

                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route('cart.remove', $cart->id) }}"
                                                onsubmit="return confirm('Hapus mobil ini dari pilihan?')"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="btn btn-outline-danger"
                                                >

                                                    <i class="fa-solid fa-trash me-1"></i>

                                                    Hapus

                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                </div>

                            </article>

                        @endif

                    @endforeach

                </div>


                <aside class="cart-summary">

                    <div class="section-kicker">
                        RINGKASAN
                    </div>

                    <h3 class="fw-bold mt-1">
                        Total Estimasi Harga
                    </h3>

                    <p class="text-secondary small">
                        {{ $carts->count() }}
                        mobil tersimpan di pilihan Anda.
                    </p>

                    <hr>

                    <div class="text-secondary small">
                        Estimasi total
                    </div>

                    <div class="cart-total">

                        Rp {{
                            number_format(
                                $total,
                                0,
                                ',',
                                '.'
                            )
                        }}

                    </div>

                    <p class="small text-secondary mt-3">
                        Total ini bukan pembayaran online.
                        Harga akhir dan ketersediaan akan dikonfirmasi oleh sales.
                    </p>


                    @php

                        $message = "Halo Thomy Showroom 👋\n\n";

                        $message .=
                            "Saya ingin berkonsultasi mengenai mobil pilihan saya:\n\n";


                        foreach ($carts as $cart) {

                            if ($cart->mobil) {

                                $warna =
                                    $cart->color?->nama_warna
                                    ?? $cart->mobil->warna
                                    ?? '-';


                                $message .=
                                    "🚗 {$cart->mobil->nama_mobil}\n";

                                $message .=
                                    "🎨 Warna: {$warna}\n";

                                $message .=
                                    "💰 Rp " .
                                    number_format(
                                        $cart->mobil->harga,
                                        0,
                                        ',',
                                        '.'
                                    ) .
                                    "\n\n";

                            }

                        }


                        $message .=
                            "Mohon informasi penawaran terbaiknya. Terima kasih.";


                        $wa = urlencode($message);

                    @endphp


                    <a
                        target="_blank"
                        href="https://wa.me/{{ config('services.whatsapp.number') }}?text={{ $wa }}"
                        class="btn cart-wa-btn w-100"
                    >

                        <i class="fa-brands fa-whatsapp me-2"></i>

                        Hubungi Sales via WhatsApp

                    </a>

                </aside>

            </div>

        @endif

    </div>
</section>

@endsection