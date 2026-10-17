@extends('layouts.admin')
@section('title', 'Tambah Mobil')
@section('page-title', 'Tambah Mobil')
@section('content')
<div class="admin-dashboard-head">
    <div><div class="admin-page-label">INVENTARIS SHOWROOM</div><h2>Tambah Mobil Baru</h2><p>Lengkapi informasi unit. Data ini akan langsung digunakan pada halaman katalog dan detail mobil user.</p></div>
</div>
<form method="POST" action="{{ route('admin.mobil.store') }}" enctype="multipart/form-data">@csrf @include('admin.mobil.form')</form>
@endsection
