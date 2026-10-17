@extends('layouts.admin')
@section('title', 'Kelola Mobil')
@section('page-title', 'Kelola Mobil')

@section('content')
<div class="admin-dashboard-head">
    <div>
        <div class="admin-page-label">INVENTARIS SHOWROOM</div>
        <h2>Kelola Semua Mobil</h2>
        <p>Tambah, perbarui, dan kelola seluruh unit agar informasi di halaman user selalu konsisten.</p>
    </div>
    <a href="{{ route('admin.mobil.create') }}" class="btn admin-primary-btn"><i class="fa-solid fa-plus"></i> Tambah Mobil</a>
</div>

<div class="admin-panel admin-list-panel">
    <div class="admin-list-toolbar">
        <div><h3 class="admin-panel-title">Daftar Unit Mobil</h3><p class="admin-panel-subtitle">{{ $mobil->total() }} unit tersimpan di sistem showroom.</p></div>
        <div class="admin-table-count"><i class="fa-solid fa-car"></i>{{ $mobil->total() }} Unit</div>
    </div>

    @if($mobil->count())
        <div class="admin-car-table-wrap">
            <table class="admin-table admin-car-table">
                <thead><tr><th>Mobil</th><th>Tahun</th><th>Harga</th><th>Stok</th><th>Status</th><th class="text-end">Aksi</th></tr></thead>
                <tbody>
                @foreach($mobil as $item)
                    <tr>
                        <td><div class="admin-car-cell"><img src="{{ asset('uploads/mobil/' . $item->gambar) }}" alt="{{ $item->nama_mobil }}" class="admin-mobil-image"><div class="admin-car-meta"><strong>{{ $item->nama_mobil }}</strong><span>{{ $item->merk }} · {{ $item->transmisi ?: '-' }} · {{ $item->bahan_bakar ?: '-' }}</span></div></div></td>
                        <td>{{ $item->tahun }}</td>
                        <td><strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong></td>
                        <td>
                            @php
                                $displayStock = $item->colors_count > 0
                                    ? (int) ($item->colors_sum_stok ?? 0)
                                    : (int) $item->stok;
                            @endphp
                            <span class="admin-stock-badge">{{ $displayStock }}</span>
                        </td>
                        <td>
                            @php
                                $effectiveReady = ($item->status ?? 'ready') === 'ready'
                                    && $displayStock > 0;
                            @endphp
                            <span class="admin-status-badge status-{{ $effectiveReady ? 'ready' : ($item->status ?: 'ready') }}">
                                {{ $effectiveReady ? 'Ready' : ucfirst($item->status ?? 'ready') }}
                            </span>
                        </td>
                        <td><div class="admin-row-actions"><a href="{{ route('admin.mobil.edit', $item->id) }}" class="admin-icon-btn" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a><form action="{{ route('admin.mobil.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus mobil {{ addslashes($item->nama_mobil) }}?')">@csrf @method('DELETE')<button type="submit" class="admin-icon-btn danger" title="Hapus"><i class="fa-solid fa-trash"></i></button></form></div></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @if($mobil->hasPages())<div class="mt-4">{{ $mobil->links() }}</div>@endif
    @else
        <div class="admin-empty-state"><i class="fa-solid fa-car"></i><h5>Belum ada mobil</h5><p>Tambahkan unit mobil pertama ke inventory showroom.</p><a href="{{ route('admin.mobil.create') }}" class="btn admin-primary-btn">Tambah Mobil</a></div>
    @endif
</div>
@endsection
