<?php

namespace App\Livewire;

use App\Models\Mobil;
use Livewire\Component;
use Livewire\WithPagination;

class MobilCatalog extends Component
{
    use WithPagination;

    protected string $paginationTheme = 'bootstrap';

    public string $search = '';
    public string $merk = '';
    public string $bahanBakar = '';
    public string $transmisi = '';
    public string $tahun = '';
    public string $harga = '';

    public function updating($name, $value): void
    {
        if ($name !== 'page') {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Mobil::query()
            ->where('status', '!=', 'sold')
            ->when($this->search, function ($q) {
                $q->where(function ($x) {
                    $x->where('nama_mobil', 'like', '%' . $this->search . '%')
                        ->orWhere('merk', 'like', '%' . $this->search . '%')
                        ->orWhere('bahan_bakar', 'like', '%' . $this->search . '%')
                        ->orWhere('transmisi', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->merk, fn ($q) => $q->where('merk', $this->merk))
            ->when($this->bahanBakar, fn ($q) => $q->where('bahan_bakar', $this->bahanBakar))
            ->when($this->transmisi, fn ($q) => $q->where('transmisi', $this->transmisi))
            ->when($this->tahun, fn ($q) => $q->where('tahun', $this->tahun));

        if ($this->harga === 'under-500') {
            $query->where('harga', '<', 500000000);
        } elseif ($this->harga === '500-1000') {
            $query->whereBetween('harga', [500000000, 1000000000]);
        } elseif ($this->harga === 'over-1000') {
            $query->where('harga', '>', 1000000000);
        }

        return view('livewire.mobil-catalog', [
            'mobil' => $query->orderByDesc('id')->paginate(9),
            'merks' => Mobil::query()
                ->where('status', '!=', 'sold')
                ->select('merk')
                ->distinct()
                ->orderBy('merk')
                ->pluck('merk'),
            'tahuns' => Mobil::query()
                ->where('status', '!=', 'sold')
                ->select('tahun')
                ->distinct()
                ->orderByDesc('tahun')
                ->pluck('tahun'),
        ]);
    }
}
