@extends('layouts.app')
@section('title','Lupa Password - Thomy Showroom')
@section('content')
<section class="auth-page" aria-labelledby="forgot-title">
    <div class="auth-orb auth-orb-one"></div><div class="auth-orb auth-orb-two"></div>
    <div class="container auth-container"><div class="auth-card">
        <div class="auth-brand-mark"><i class="fa-solid fa-key"></i></div>
        <div class="auth-kicker">PEMULIHAN AKUN</div>
        <h1 id="forgot-title" class="auth-title">Lupa Password?</h1>
        <p class="auth-subtitle">Masukkan email akunmu. Kami akan mengirimkan tautan untuk membuat password baru.</p>
        @if (session('status'))<div class="auth-alert auth-alert-success" role="status"><i class="fa-solid fa-circle-check"></i><div>{{ session('status') }}</div></div>@endif
        @if ($errors->any())<div class="auth-alert auth-alert-danger" role="alert"><i class="fa-solid fa-circle-exclamation"></i><div><strong>Periksa kembali.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf
            <div class="auth-field-group"><label for="email" class="auth-label">Alamat Email</label><div class="auth-field @error('email') has-error @enderror"><i class="fa-regular fa-envelope auth-field-icon"></i><input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nama@email.com" autocomplete="email" inputmode="email" class="auth-input" required autofocus></div>@error('email')<div class="auth-field-error">{{ $message }}</div>@enderror</div>
            <button class="auth-btn" type="submit"><i class="fa-solid fa-paper-plane"></i><span>Kirim Tautan Reset</span><i class="fa-solid fa-arrow-right auth-btn-arrow"></i></button>
        </form>
        <a href="{{ route('login') }}" class="auth-back" data-nav-link><i class="fa-solid fa-arrow-left"></i> Kembali ke login</a>
    </div></div>
</section>
@endsection
