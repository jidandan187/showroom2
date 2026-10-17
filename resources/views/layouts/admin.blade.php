<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="theme-color" content="#071f2a">
    <title>@yield('title', 'Admin Panel') · Thomy Showroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/css/admin.css','resources/js/app.js'])
    @stack('head')
</head>
<body class="admin-body">
<div class="admin-layout" id="adminLayout">
    <div class="admin-overlay" id="adminOverlay"></div>
    <aside class="admin-sidebar" id="adminSidebar">
        <a href="{{ route('admin.dashboard') }}" class="admin-logo">
            <span class="admin-logo-icon"><i class="fa-solid fa-car-side"></i></span>
            <span><span class="admin-logo-title d-block">Thomy Showroom</span><span class="admin-logo-subtitle d-block">Administrator</span></span>
        </a>
        @php($adminUser = auth('admin')->user())
        <div class="admin-user-card">
            <div class="admin-user-avatar">{{ strtoupper(substr($adminUser?->name ?? 'A', 0, 1)) }}</div>
            <div class="admin-user-info"><strong>{{ $adminUser?->name ?? 'Administrator' }}</strong><span>{{ $adminUser?->email ?? 'Administrator' }}</span></div>
        </div>
        <div class="admin-menu-title">MENU UTAMA</div>
        <nav class="admin-nav">
            <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
            <a href="{{ route('admin.mobil.index') }}" class="admin-nav-link {{ request()->routeIs('admin.mobil.*') ? 'active' : '' }}"><i class="fa-solid fa-car"></i><span>Kelola Mobil</span></a>
        </nav>
        <div class="admin-sidebar-bottom">
            <div class="admin-menu-title">WEBSITE</div>
            <nav class="admin-nav">
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="admin-nav-link"><i class="fa-solid fa-arrow-up-right-from-square"></i><span>Lihat Website</span></a>
                <form action="{{ route('admin.logout') }}" method="POST" class="admin-logout-form">@csrf<button type="submit" class="admin-nav-link admin-logout"><i class="fa-solid fa-right-from-bracket"></i><span>Logout</span></button></form>
            </nav>
        </div>
    </aside>
    <main class="admin-main">
        <header class="admin-topbar">
            <div class="admin-topbar-left">
                <button type="button" class="admin-menu-toggle" id="adminMenuToggle" aria-label="Buka menu"><i class="fa-solid fa-bars"></i></button>
                <div><div class="admin-breadcrumb">THOMY SHOWROOM</div><h1 class="admin-page-title">@yield('page-title', 'Dashboard')</h1></div>
            </div>
            <div class="admin-topbar-right">
                <div class="admin-status"><span class="admin-status-dot"></span><span>Sistem Aktif</span></div>
                <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="admin-view-site"><i class="fa-solid fa-globe"></i><span>Lihat Website</span></a>
            </div>
        </header>
        <div class="admin-content">
            @foreach(['success'=>'circle-check','info'=>'circle-info','error'=>'circle-exclamation'] as $type=>$icon)
                @if(session($type))<div class="alert alert-{{ $type === 'error' ? 'danger' : $type }} border-0 rounded-4 mb-4"><i class="fa-solid fa-{{ $icon }} me-2"></i>{{ session($type) }}</div>@endif
            @endforeach
            @if($errors->any())<div class="alert alert-danger border-0 rounded-4 mb-4"><strong><i class="fa-solid fa-triangle-exclamation me-2"></i>Periksa kembali data.</strong><ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </div>
    </main>
    <nav class="admin-mobile-nav">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fa-solid fa-house"></i><span>Dashboard</span></a>
        <a href="{{ route('admin.mobil.index') }}" class="{{ request()->routeIs('admin.mobil.*') ? 'active' : '' }}"><i class="fa-solid fa-car"></i><span>Mobil</span></a>
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-globe"></i><span>Website</span></a>
    </nav>
</div>
<script>
document.addEventListener('DOMContentLoaded',()=>{const layout=document.getElementById('adminLayout'),toggle=document.getElementById('adminMenuToggle'),overlay=document.getElementById('adminOverlay');const close=()=>layout?.classList.remove('menu-open');toggle?.addEventListener('click',()=>layout?.classList.toggle('menu-open'));overlay?.addEventListener('click',close);window.addEventListener('resize',()=>{if(innerWidth>991)close()});document.querySelectorAll('.admin-sidebar a').forEach(a=>a.addEventListener('click',()=>{if(innerWidth<=991)close()}));});
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body></html>
