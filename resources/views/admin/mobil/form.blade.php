@php
    $isEdit = isset($mobil);
    $colors = old('colors');
    if ($colors === null && $isEdit) {
        $colors = $mobil->colors->map(fn($color) => [
            'nama_warna' => $color->nama_warna,
            'kode_warna' => $color->kode_warna,
            'stok' => $color->stok,
            'tersedia' => $color->tersedia,
        ])->values()->all();
    }
    $colors = $colors ?? [];
@endphp

<div class="admin-form-shell">
    <div class="admin-form-main">
        <section class="admin-form-card">
            <h3>Informasi Utama</h3>
            <p>Data dasar yang tampil pada katalog dan halaman detail mobil.</p>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Merk</label><input type="text" name="merk" class="form-control" value="{{ old('merk', $mobil->merk ?? '') }}" placeholder="Contoh: Toyota" required></div>
                <div class="col-md-6"><label class="form-label">Nama Mobil</label><input type="text" name="nama_mobil" class="form-control" value="{{ old('nama_mobil', $mobil->nama_mobil ?? '') }}" placeholder="Contoh: Fortuner 2.8 GR Sport" required></div>
                <div class="col-md-4"><label class="form-label">Tahun</label><input type="number" name="tahun" min="1900" max="{{ now()->year + 1 }}" class="form-control" value="{{ old('tahun', $mobil->tahun ?? now()->year) }}" required></div>
                <div class="col-md-4"><label class="form-label">Harga (Rp)</label><input type="number" name="harga" min="0" class="form-control" value="{{ old('harga', $mobil->harga ?? '') }}" required></div>
                <div class="col-md-4"><label class="form-label">Stok Total</label><input type="number" name="stok" min="0" class="form-control" value="{{ old('stok', $mobil->stok ?? 0) }}" required></div>
                <div class="col-md-4"><label class="form-label">Status</label><select name="status" class="form-select"><option value="ready" @selected(old('status', $mobil->status ?? 'ready') === 'ready')>Ready</option><option value="booking" @selected(old('status', $mobil->status ?? '') === 'booking')>Booking</option><option value="sold" @selected(old('status', $mobil->status ?? '') === 'sold')>Sold</option></select></div>
                <div class="col-md-4"><label class="form-label">Transmisi</label><select name="transmisi" class="form-select"><option value="">Pilih transmisi</option>@foreach(['Automatic','Manual','CVT','DCT'] as $value)<option value="{{ $value }}" @selected(old('transmisi', $mobil->transmisi ?? '') === $value)>{{ $value }}</option>@endforeach</select></div>
                <div class="col-md-4"><label class="form-label">Bahan Bakar</label><select name="bahan_bakar" class="form-select"><option value="">Pilih bahan bakar</option>@foreach(['Bensin','Diesel','Hybrid','Listrik'] as $value)<option value="{{ $value }}" @selected(old('bahan_bakar', $mobil->bahan_bakar ?? '') === $value)>{{ $value }}</option>@endforeach</select></div>
                <div class="col-12"><label class="form-label">Warna Utama</label><input type="text" name="warna" class="form-control" value="{{ old('warna', $mobil->warna ?? '') }}" placeholder="Contoh: Putih Pearl, Hitam"></div>
                <div class="col-12"><label class="form-label">Deskripsi</label><textarea name="deskripsi" class="form-control" required placeholder="Tulis deskripsi singkat dan jelas mengenai unit mobil.">{{ old('deskripsi', $mobil->deskripsi ?? '') }}</textarea></div>
            </div>
        </section>

        <section class="admin-form-card">
            <h3>Foto Mobil</h3>
            <p>Gunakan foto yang jelas agar tampilan katalog dan detail mobil tetap menarik.</p>
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label">Foto Utama {{ $isEdit ? '(opsional)' : '' }}</label><input type="file" name="gambar" class="form-control" accept="image/*" @if(!$isEdit) required @endif></div>
                <div class="col-md-6"><label class="form-label">Foto Tambahan</label><input type="file" name="images[]" class="form-control" accept="image/*" multiple></div>
            </div>
            @if($isEdit && $mobil->images->count())
                <div class="admin-form-gallery mt-3">
                    @foreach($mobil->images as $image)
                        <div class="admin-form-gallery-item"><img src="{{ asset('uploads/mobil/' . $image->gambar) }}" alt="Foto {{ $mobil->nama_mobil }}"><form action="{{ route('admin.mobil-images.destroy', $image->id) }}" method="POST" class="mt-2">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Hapus foto ini?')">Hapus Foto</button></form></div>
                    @endforeach
                </div>
            @endif
        </section>

        <section class="admin-form-card">
            <div class="admin-panel-heading">
                <div><h3>Warna dan Stok</h3><p>Setiap warna dapat memiliki stok sendiri. Stok warna di atas 0 dan dicentang tersedia akan muncul sebagai pilihan user.</p></div>
                <button type="button" class="btn admin-secondary-btn" id="addColorBtn"><i class="fa-solid fa-plus me-2"></i>Tambah Warna</button>
            </div>
            <div id="color-container" class="d-grid gap-2">
                @foreach($colors as $index => $color)
                    <div class="row g-2 align-items-end admin-color-row color-row">
                        <div class="col-md-4"><label class="form-label">Nama Warna</label><input type="text" name="colors[{{ $index }}][nama_warna]" class="form-control" value="{{ $color['nama_warna'] ?? '' }}" placeholder="Contoh: Putih Pearl"></div>
                        <div class="col-md-2"><label class="form-label">Kode</label><input type="color" name="colors[{{ $index }}][kode_warna]" class="form-control form-control-color w-100" value="{{ $color['kode_warna'] ?? '#888888' }}"></div>
                        <div class="col-md-2"><label class="form-label">Stok</label><input type="number" min="0" name="colors[{{ $index }}][stok]" class="form-control" value="{{ $color['stok'] ?? 0 }}"></div>
                        <div class="col-md-2"><div class="form-check mb-2"><input type="checkbox" name="colors[{{ $index }}][tersedia]" value="1" class="form-check-input" @checked(!empty($color['tersedia']))><label class="form-check-label">Tersedia</label></div></div>
                        <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100 admin-color-remove remove-color">Hapus</button></div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="admin-form-actions">
            <a href="{{ route('admin.mobil.index') }}" class="admin-secondary-btn">Batal</a>
            <button type="submit" class="btn admin-primary-btn"><i class="fa-solid fa-floppy-disk"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Mobil' }}</button>
        </div>
    </div>

    <aside class="admin-form-side">
        <section class="admin-form-card">
            <h3>Preview Foto</h3>
            <p>Foto utama yang digunakan pada katalog.</p>
            @if($isEdit && $mobil->gambar)
                <img src="{{ asset('uploads/mobil/' . $mobil->gambar) }}" alt="{{ $mobil->nama_mobil }}" class="admin-form-preview">
            @else
                <div class="admin-form-placeholder"><span><i class="fa-solid fa-image me-2"></i>Belum ada preview</span></div>
            @endif
        </section>
    </aside>
</div>

<script>
(() => {
    const container = document.getElementById('color-container');
    const addButton = document.getElementById('addColorBtn');
    let index = {{ count($colors) }};
    const bindRemove = (scope = document) => scope.querySelectorAll('.remove-color').forEach(button => {
        if (button.dataset.bound) return;
        button.dataset.bound = '1';
        button.addEventListener('click', () => button.closest('.color-row')?.remove());
    });
    addButton?.addEventListener('click', () => {
        const html = `<div class="row g-2 align-items-end admin-color-row color-row">
            <div class="col-md-4"><label class="form-label">Nama Warna</label><input type="text" name="colors[${index}][nama_warna]" class="form-control" placeholder="Contoh: Hitam"></div>
            <div class="col-md-2"><label class="form-label">Kode</label><input type="color" name="colors[${index}][kode_warna]" class="form-control form-control-color w-100" value="#888888"></div>
            <div class="col-md-2"><label class="form-label">Stok</label><input type="number" min="0" name="colors[${index}][stok]" class="form-control" value="0"></div>
            <div class="col-md-2"><div class="form-check mb-2"><input type="checkbox" name="colors[${index}][tersedia]" value="1" class="form-check-input" checked><label class="form-check-label">Tersedia</label></div></div>
            <div class="col-md-2"><button type="button" class="btn btn-outline-danger w-100 admin-color-remove remove-color">Hapus</button></div>
        </div>`;
        container.insertAdjacentHTML('beforeend', html);
        bindRemove(container.lastElementChild);
        index++;
    });
    bindRemove();
})();
</script>
