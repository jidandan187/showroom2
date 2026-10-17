@extends('layouts.app')
@section('title','Konfirmasi Password - Thomy Showroom')
@section('content')
<section class="auth-page" aria-labelledby="confirm-title">
    <div class="auth-orb auth-orb-one"></div><div class="auth-orb auth-orb-two"></div>
    <div class="container auth-container"><div class="auth-card">
        <div class="auth-brand-mark"><i class="fa-solid fa-lock"></i></div>
        <div class="auth-kicker">AREA TERLINDUNGI</div>
        <h1 id="confirm-title" class="auth-title">Konfirmasi Password</h1>
        <p class="auth-subtitle">Untuk melanjutkan ke area aman, masukkan password akunmu sekali lagi.</p>
        @if ($errors->any())<div class="auth-alert auth-alert-danger" role="alert"><i class="fa-solid fa-circle-exclamation"></i><div><strong>Periksa kembali.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
        <form method="POST" action="{{ route('password.confirm') }}" class="auth-form">
            @csrf
            <div class="auth-field-group"><label for="password" class="auth-label">Password</label><div class="auth-field"><i class="fa-solid fa-lock auth-field-icon"></i><input id="password" type="password" name="password" autocomplete="current-password" class="auth-input auth-input-password" required placeholder="Masukkan password"><button type="button" class="auth-eye" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button></div>@error('password')<div class="auth-field-error">{{ $message }}</div>@enderror</div>
            <button class="auth-btn" type="submit"><i class="fa-solid fa-check"></i><span>Konfirmasi</span><i class="fa-solid fa-arrow-right auth-btn-arrow"></i></button>
        </form>
        <a href="{{ route('home') }}" class="auth-back" data-nav-link><i class="fa-solid fa-arrow-left"></i> Kembali ke showroom</a>
    </div></div>
</section>
@endsection
