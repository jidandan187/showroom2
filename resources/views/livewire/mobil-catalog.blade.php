<div class="catalog-component">
    <div class="catalog-panel">
        <div class="catalog-filter-head">
            <div>
                <div class="section-kicker">CARI UNIT</div>
                <h3>Temukan mobil yang kamu cari</h3>
                <p>Gunakan pencarian atau filter untuk mempersempit pilihan.</p>
            </div>
            <span class="catalog-count">{{ $mobil->total() }} unit</span>
        </div>

        <div class="catalog-filter-grid">
            <div class="filter-field filter-search">
                <label for="catalog-search">Cari mobil atau merk</label>
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input id="catalog-search" wire:model.live.debounce.300ms="search"
                           type="search" autocomplete="off"
                           placeholder="Contoh: Fortuner, Honda, Mitsubishi...">
                </div>
            </div>

            <div class="filter-field">
                <label for="catalog-merk">Merk</label>
                <select id="catalog-merk" wire:model.live="merk" class="form-select">
                    <option value="">Semua Merk</option>
                    @foreach($merks as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label for="catalog-tahun">Tahun</label>
                <select id="catalog-tahun" wire:model.live="tahun" class="form-select">
                    <option value="">Semua Tahun</option>
                    @foreach($tahuns as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-field">
                <label for="catalog-transmisi">Transmisi</label>
                <select id="catalog-transmisi" wire:model.live="transmisi" class="form-select">
                    <option value="">Semua</option>
                    <option value="Automatic">Automatic</option>
                    <option value="Manual">Manual</option>
                </select>
            </div>

            <div class="filter-field">
                <label for="catalog-harga">Harga</label>
                <select id="catalog-harga" wire:model.live="harga" class="form-select">
                    <option value="">Semua Harga</option>
                    <option value="under-500">&lt; Rp 500 Juta</option>
                    <option value="500-1000">Rp 500 Juta – 1 M</option>
                    <option value="over-1000">&gt; Rp 1 Miliar</option>
                </select>
            </div>
        </div>

        <div class="fuel-filter">
            <div>
                <span class="filter-label">Jenis bahan bakar</span>
                <span class="filter-hint">Pilih salah satu</span>
            </div>
            <div class="fuel-pills">
                @foreach([
                    '' => 'Semua',
                    'Bensin' => 'Bensin',
                    'Diesel' => 'Diesel',
                    'Listrik' => 'Listrik',
                ] as $value => $label)
                    <button type="button"
                            wire:click="$set('bahanBakar', '{{ $value }}')"
                            class="fuel-pill {{ $bahanBakar === $value ? 'active' : '' }}"
                            aria-pressed="{{ $bahanBakar === $value ? 'true' : 'false' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <div class="catalog-results-head">
        <div>
            <div class="section-kicker">SHOWROOM INVENTORY</div>
            <h3>Mobil tersedia</h3>
            <p>
                @if($mobil->total())
                    Menampilkan <strong>{{ $mobil->firstItem() }}–{{ $mobil->lastItem() }}</strong>
                    dari <strong>{{ $mobil->total() }}</strong> mobil
                @else
                    Tidak ada mobil yang cocok dengan filter.
                @endif
            </p>
        </div>
        <div class="catalog-page-label">
            Halaman {{ $mobil->currentPage() }} / {{ $mobil->lastPage() }}
        </div>
    </div>

    <div class="row g-3 catalog-car-grid">
        @forelse($mobil as $item)
            <div class="col-6 col-md-4 col-lg-4 col-xl-3" wire:key="mobil-card-{{ $item->id }}">
                <article class="card-mobil">
                    <a class="card-image-link" href="{{ route('mobil.detail', ['id' => $item->id]) }}" aria-label="Lihat {{ $item->nama_mobil }}">
                        <div class="card-image">
                            <img src="{{ asset('uploads/mobil/' . $item->gambar) }}"
                                 alt="{{ $item->nama_mobil }}" loading="lazy">
                            <span class="badge-year">{{ $item->tahun }}</span>
                        </div>
                    </a>

                    <div class="card-mobil-body">
                        <div class="card-topline">
                            <span class="card-brand">{{ $item->merk }}</span>
                            @if(($item->status ?? 'ready') === 'ready')
                                <span class="card-status">Tersedia</span>
                            @else
                                <span class="card-status muted">{{ ucfirst($item->status) }}</span>
                            @endif
                        </div>

                        <h4>{{ $item->nama_mobil }}</h4>

                        <div class="card-spec">
                            <span><i class="fa-solid fa-gears"></i>{{ $item->transmisi ?: '-' }}</span>
                            <span><i class="fa-solid fa-gas-pump"></i>{{ $item->bahan_bakar ?: '-' }}</span>
                        </div>

                        <div class="card-price-label">Mulai dari</div>
                        <div class="card-price">Rp {{ number_format($item->harga, 0, ',', '.') }}</div>

                        <a href="{{ route('mobil.detail', ['id' => $item->id]) }}"
                           class="btn btn-gold w-100 card-detail-link">
                            Lihat Detail <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state catalog-empty">
                    <div class="empty-icon"><i class="fa-solid fa-car-rear"></i></div>
                    <h4>Mobil tidak ditemukan</h4>
                    <p>Coba ubah kata kunci atau filter pencarian.</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($mobil->hasPages())
        <div class="catalog-pagination" aria-label="Navigasi halaman katalog">
            {{ $mobil->links() }}
        </div>
    @endif
</div>
