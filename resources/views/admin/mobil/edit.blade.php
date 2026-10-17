@extends('layouts.admin')
@section('title', 'Edit Mobil')
@section('page-title', 'Edit Mobil')
@section('content')
<div class="admin-dashboard-head">
    <div><div class="admin-page-label">INVENTARIS SHOWROOM</div><h2>Edit Mobil</h2><p>Perbarui informasi, stok, warna, dan foto agar tetap sinkron dengan halaman user.</p></div>
</div>
<form method="POST" action="{{ route('admin.mobil.update', $mobil) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.mobil.form')</form>
@endsection
