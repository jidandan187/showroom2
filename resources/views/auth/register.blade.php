@extends('layouts.app')

@section('title', 'Daftar - Thomy Showroom')

@section('content')
<section class="auth-page auth-page-register" aria-labelledby="register-title">
    <div class="auth-orb auth-orb-one"></div>
    <div class="auth-orb auth-orb-two"></div>

    <div class="container auth-container">
        <div class="auth-card">
            <div class="auth-brand-mark"><i class="fa-solid fa-user-plus"></i></div>
            <div class="auth-kicker">AKUN BARU</div>
            <h1 id="register-title" class="auth-title">Buat Akun Anda</h1>
            <p class="auth-subtitle">Daftar untuk menyimpan mobil pilihan dan mendapatkan jalur konsultasi yang lebih praktis.</p>

            @if ($errors->any())
                <div class="auth-alert auth-alert-danger" role="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <div><strong>Periksa data berikut.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf
                <div class="auth-field-group">
                    <label for="name" class="auth-label">Nama Lengkap</label>
                    <div class="auth-field @error('name') has-error @enderror">
                        <i class="fa-regular fa-user auth-field-icon"></i>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" autocomplete="name" class="auth-input" required autofocus>
                    </div>
                    @error('name')<div class="auth-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field-group">
                    <label for="email" class="auth-label">Alamat Email</label>
                    <div class="auth-field @error('email') has-error @enderror">
                        <i class="fa-regular fa-envelope auth-field-icon"></i>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" inputmode="email" class="auth-input" required>
                    </div>
                    @error('email')<div class="auth-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field-group">
                    <label for="password" class="auth-label">Password</label>
                    <div class="auth-field @error('password') has-error @enderror">
                        <i class="fa-solid fa-lock auth-field-icon"></i>
                        <input id="password" type="password" name="password" placeholder="Minimal 8 karakter" autocomplete="new-password" class="auth-input auth-input-password" required minlength="8">
                        <button type="button" class="auth-eye" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button>
                    </div>
                    @error('password')<div class="auth-field-error">{{ $message }}</div>@enderror
                </div>

                <div class="auth-field-group">
                    <label for="password_confirmation" class="auth-label">Konfirmasi Password</label>
                    <div class="auth-field">
                        <i class="fa-solid fa-shield-halved auth-field-icon"></i>
                        <input id="password_confirmation" type="password" name="password_confirmation" placeholder="Ulangi password" autocomplete="new-password" class="auth-input auth-input-password" required minlength="8">
                        <button type="button" class="auth-eye" data-password-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button>
                    </div>
                </div>

                <button type="submit" class="auth-btn"><i class="fa-solid fa-user-plus"></i><span>Buat Akun</span><i class="fa-solid fa-arrow-right auth-btn-arrow"></i></button>
            </form>

            <p class="auth-switch">Sudah memiliki akun? <a href="{{ route('login') }}" data-nav-link>Masuk sekarang <i class="fa-solid fa-arrow-right"></i></a></p>
            <a href="{{ route('home') }}" class="auth-back" data-nav-link><i class="fa-solid fa-arrow-left"></i> Kembali ke showroom</a>
        </div>
    </div>
</section>
@endsection
