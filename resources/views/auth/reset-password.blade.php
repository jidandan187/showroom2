@extends('layouts.app')
@section('title','Reset Password - Thomy Showroom')
@section('content')
<section class="auth-page" aria-labelledby="reset-title">
    <div class="auth-orb auth-orb-one"></div><div class="auth-orb auth-orb-two"></div>
    <div class="container auth-container"><div class="auth-card">
        <div class="auth-brand-mark"><i class="fa-solid fa-shield-halved"></i></div>
        <div class="auth-kicker">KEAMANAN AKUN</div>
        <h1 id="reset-title" class="auth-title">Buat Password Baru</h1>
        <p class="auth-subtitle">Gunakan password yang kuat dan mudah kamu ingat untuk menjaga akun tetap aman.</p>
        @if ($errors->any())<div class="auth-alert auth-alert-danger" role="alert"><i class="fa-solid fa-circle-exclamation"></i><div><strong>Periksa kembali.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div></div>@endif
        <form method="POST" action="{{ route('password.store') }}" class="auth-form">
            @csrf<input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="auth-field-group"><label for="email" class="auth-label">Alamat Email</label><div class="auth-field @error('email') has-error @enderror"><i class="fa-regular fa-envelope auth-field-icon"></i><input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" autocomplete="username" class="auth-input" required autofocus></div>@error('email')<div class="auth-field-error">{{ $message }}</div>@enderror</div>
            <div class="auth-field-group"><label for="password" class="auth-label">Password Baru</label><div class="auth-field @error('password') has-error @enderror"><i class="fa-solid fa-lock auth-field-icon"></i><input id="password" type="password" name="password" autocomplete="new-password" class="auth-input auth-input-password" required minlength="8" placeholder="Minimal 8 karakter"><button type="button" class="auth-eye" data-password-toggle="password" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button></div>@error('password')<div class="auth-field-error">{{ $message }}</div>@enderror</div>
            <div class="auth-field-group"><label for="password_confirmation" class="auth-label">Konfirmasi Password</label><div class="auth-field"><i class="fa-solid fa-shield-halved auth-field-icon"></i><input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password" class="auth-input auth-input-password" required minlength="8" placeholder="Ulangi password"><button type="button" class="auth-eye" data-password-toggle="password_confirmation" aria-label="Tampilkan password" aria-pressed="false"><i class="fa-regular fa-eye"></i></button></div>@error('password_confirmation')<div class="auth-field-error">{{ $message }}</div>@enderror</div>
            <button class="auth-btn" type="submit"><i class="fa-solid fa-key"></i><span>Simpan Password Baru</span><i class="fa-solid fa-arrow-right auth-btn-arrow"></i></button>
        </form>
        <a href="{{ route('login') }}" class="auth-back" data-nav-link><i class="fa-solid fa-arrow-left"></i> Kembali ke login</a>
    </div></div>
</section>
@endsection
