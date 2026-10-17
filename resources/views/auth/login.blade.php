@extends('layouts.app')

@section('title', 'Masuk - Thomy Showroom')

@section('content')
<section class="auth-page" aria-labelledby="login-title">
    <div class="auth-orb auth-orb-one"></div>
    <div class="auth-orb auth-orb-two"></div>

    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand-mark"><i class="fa-solid fa-car-side"></i></div>
            <div class="auth-kicker">AKUN THOMY SHOWROOM</div>
            <h1 id="login-title" class="auth-title">Selamat Datang</h1>
            <p class="auth-subtitle">Masuk untuk menyimpan mobil pilihan dan melanjutkan konsultasi dengan sales.</p>

            @if ($errors->any())
                <div class="auth-alert auth-alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div><strong>Periksa kembali.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="auth-form" novalidate>
                @csrf
                <div class="auth-field-group">
                    <label for="email" class="auth-label">Alamat Email</label>
                    <div class="auth-field @error('email') has-error @enderror">
                        <i class="fa-regular fa-envelope auth-field-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" inputmode="email" class="auth-input" required autofocus>
                    </div>
                    @error('email')<div class="auth-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field-group">
                    <div class="auth-label-row"><label for="password" class="auth-label">Password</label><a href="{{ route('password.request') }}" class="auth-small-link">Lupa password?</a></div>
                    <div class="auth-field @error('password') has-error @enderror">
                        <i class="fa-solid fa-lock auth-field-icon"></i>
                        <input id="password" type="password" name="password" placeholder="Masukkan password" autocomplete="current-password" class="auth-input auth-input-password" required>
                        <button type="button" class="auth-eye" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button>
                    </div>
                    @error('password')<div class="auth-field-error">{{ $message }}</div>@enderror
                </div>

                <label class="auth-check"><input type="checkbox" name="remember" id="remember"><span>Ingat saya di perangkat ini</span></label>

                <button type="submit" class="auth-btn"><i class="fa-solid fa-right-to-bracket"></i><span>Masuk ke Showroom</span><i class="fa-solid fa-arrow-right auth-btn-arrow"></i></button>
            </form>

            <div class="auth-divider"><span>atau</span></div>
            <p class="auth-switch">Belum memiliki akun? <a href="{{ route('register') }}" data-nav-link>Daftar sekarang <i class="fa-solid fa-arrow-right"></i></a></p>
            <a href="{{ route('home') }}" class="auth-back" data-nav-link><i class="fa-solid fa-arrow-left"></i> Kembali ke showroom</a>
        </div>
    </div>
</section>
@endsection
