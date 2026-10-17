<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#0b1722">
    <meta name="description" content="Thomy Showroom — katalog mobil pilihan dengan layanan konsultasi sales melalui WhatsApp.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Thomy Showroom')</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/thomy-fixes.css') }}">
    @livewireStyles
    @stack('head')
</head>
<body class="public-body">
<div id="pageTransition" class="page-transition" aria-hidden="true"></div>

<nav class="site-nav" aria-label="Navigasi utama">
  <div class="container site-nav-inner">
    <a href="{{ route('home') }}" class="brand" data-nav-link>
      <span class="brand-icon"><i class="fa-solid fa-car-side"></i></span>
      <span>Thomy Showroom</span>
    </a>

    <div class="desktop-nav">
      <a href="{{ route('home') }}" data-nav-link>Beranda</a>
      <a href="{{ route('home') }}#katalog" data-nav-link>Katalog</a>
      <a href="{{ route('home') }}#brand" data-nav-link>Merk</a>
    </div>

    <div class="nav-actions">
      @auth
        <a href="{{ route('cart.index') }}" class="nav-pill nav-favorite" data-nav-link><i class="fa-regular fa-heart"></i> Mobil Pilihan</a>
        @if(auth('admin')->check())
          <a href="{{ route('admin.dashboard') }}" class="nav-pill nav-admin" data-nav-link><i class="fa-solid fa-gauge-high"></i> Admin</a>
        @endif
        <details class="nav-user">
          <summary>
            <span class="avatar">{{ strtoupper(substr(auth()->user()->name,0,1)) }}</span>
            <span><span class="user-name d-block">{{ auth()->user()->name }}</span><span class="user-email d-block">{{ auth()->user()->email }}</span></span>
            <i class="fa-solid fa-chevron-down ms-1"></i>
          </summary>
          <div class="nav-user-menu">
            <a href="{{ route('profile.edit') }}" data-nav-link><i class="fa-regular fa-user"></i> Profil</a>
            <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Logout</button></form>
          </div>
        </details>
      @else
        <a href="{{ route('login') }}" class="nav-pill nav-favorite" data-nav-link>Masuk</a>
        <a href="{{ route('register') }}" class="nav-pill nav-admin" data-nav-link>Daftar</a>
      @endauth
    </div>

    <button class="mobile-menu-btn" id="mobileMenuBtn" type="button" aria-label="Buka menu" aria-expanded="false" aria-controls="mobileMenu">
      <i class="fa-solid fa-bars"></i>
    </button>
  </div>
</nav>

<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>
<aside class="mobile-menu" id="mobileMenu" aria-label="Menu mobile" aria-hidden="true">
  <div class="mobile-menu-head">
    <strong>Menu</strong>
    <button type="button" id="mobileMenuClose" aria-label="Tutup menu"><i class="fa-solid fa-xmark"></i></button>
  </div>
  <div class="mobile-menu-links">
    <a href="{{ route('home') }}" data-nav-link><i class="fa-solid fa-house"></i><span>Beranda</span></a>
    <a href="{{ route('home') }}#katalog" data-nav-link><i class="fa-solid fa-car"></i><span>Katalog</span></a>
    <a href="{{ route('home') }}#brand" data-nav-link><i class="fa-solid fa-tags"></i><span>Merk</span></a>
    @auth
      <a href="{{ route('cart.index') }}" data-nav-link><i class="fa-regular fa-heart"></i><span>Mobil Pilihan</span></a>
      <a href="{{ route('profile.edit') }}" data-nav-link><i class="fa-regular fa-user"></i><span>Profil Saya</span></a>
      @if(auth('admin')->check())<a href="{{ route('admin.dashboard') }}" data-nav-link><i class="fa-solid fa-gauge-high"></i><span>Admin Panel</span></a>@endif
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit"><i class="fa-solid fa-right-from-bracket"></i><span>Keluar</span></button></form>
    @else
      <a href="{{ route('login') }}" data-nav-link><i class="fa-solid fa-right-to-bracket"></i><span>Masuk</span></a>
      <a href="{{ route('register') }}" data-nav-link><i class="fa-solid fa-user-plus"></i><span>Daftar</span></a>
    @endauth
  </div>
</aside>

@if(session('success') || session('error') || session('info'))
  <div class="container flash-wrap">
    <div class="alert {{ session('error') ? 'alert-danger' : (session('info') ? 'alert-warning' : 'alert-success') }} flash-alert" role="alert">
      <i class="fa-solid {{ session('error') ? 'fa-circle-exclamation' : (session('info') ? 'fa-circle-info' : 'fa-circle-check') }}"></i>
      <span>{{ session('success') ?? session('error') ?? session('info') }}</span>
    </div>
  </div>
@endif

<main id="pageContent" class="page-content">
  @yield('content')
</main>

<nav class="bottom-nav" aria-label="Navigasi mobile bawah">
  <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" data-nav-link><i class="fa-solid fa-house"></i><span>Beranda</span></a>
  <a href="{{ route('home') }}#katalog" data-nav-link><i class="fa-solid fa-car"></i><span>Katalog</span></a>
  <a href="{{ route('cart.index') }}" class="{{ request()->routeIs('cart.*') ? 'active' : '' }}" data-nav-link><i class="fa-solid fa-heart"></i><span>Pilihan</span></a>
  @auth
    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}" data-nav-link><i class="fa-regular fa-user"></i><span>Akun</span></a>
  @else
    <a href="{{ route('login') }}" class="{{ request()->routeIs('login') || request()->routeIs('register') ? 'active' : '' }}" data-nav-link><i class="fa-regular fa-user"></i><span>Masuk</span></a>
  @endauth
</nav>

@livewireScripts
@stack('scripts')
</body>
</html>
