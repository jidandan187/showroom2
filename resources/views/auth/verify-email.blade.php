@extends('layouts.app')
@section('title','Verifikasi Email - Thomy Showroom')
@section('content')
<section class="auth-page" aria-labelledby="verify-title">
    <div class="auth-orb auth-orb-one"></div><div class="auth-orb auth-orb-two"></div>
    <div class="container auth-container"><div class="auth-card">
        <div class="auth-brand-mark"><i class="fa-solid fa-envelope-circle-check"></i></div>
        <div class="auth-kicker">VERIFIKASI AKUN</div>
        <h1 id="verify-title" class="auth-title">Verifikasi Email</h1>
        <p class="auth-subtitle">Tautan verifikasi sudah dikirim ke email akunmu. Buka inbox dan klik tautannya untuk melanjutkan.</p>
        @if (session('status') == 'verification-link-sent')<div class="auth-alert auth-alert-success" role="status"><i class="fa-solid fa-circle-check"></i><div>Tautan verifikasi baru sudah dikirim.</div></div>@endif
        <div class="verify-actions">
            <form method="POST" action="{{ route('verification.send') }}">@csrf<button class="auth-btn" type="submit"><i class="fa-solid fa-paper-plane"></i><span>Kirim Ulang Email</span></button></form>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="auth-back auth-logout-link"><i class="fa-solid fa-right-from-bracket"></i> Keluar</button></form>
        </div>
    </div></div>
</section>
@endsection
