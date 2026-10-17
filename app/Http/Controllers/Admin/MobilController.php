<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mobil;
use App\Models\MobilImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MobilController extends Controller
{
    public function index()
    {
        $mobil = Mobil::query()
            ->withCount([
                'images',
                'colors'
            ])
            ->withSum('colors', 'stok')
            ->latest()
            ->paginate(12);

        return view(
            'admin.mobil.index',
            compact('mobil')
        );
    }


    public function create()
    {
        return view('admin.mobil.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_mobil' => [
                'required',
                'string',
                'max:255',
            ],

            'merk' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'integer',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],

            'deskripsi' => [
                'required',
            ],

            'gambar' => [
                'required',
                'image',
                'max:4096',
            ],

            'status' => [
                'nullable',
                'in:ready,booking,sold',
            ],

            'transmisi' => [
                'nullable',
                'string',
                'max:100',
            ],

            'bahan_bakar' => [
                'nullable',
                'string',
                'max:100',
            ],

            'warna' => [
                'nullable',
                'string',
                'max:255',
            ],

            'images.*' => [
                'nullable',
                'image',
                'max:4096',
            ],

            'colors' => [
                'nullable',
                'array',
            ],

            'colors.*.nama_warna' => [
                'nullable',
                'string',
                'max:100',
            ],

            'colors.*.kode_warna' => [
                'nullable',
                'string',
                'max:20',
            ],

            'colors.*.stok' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'colors.*.tersedia' => [
                'nullable',
            ],

        ]);


        // FOTO UTAMA
        $data['gambar'] = $this->upload(
            $request->file('gambar')
        );


        // BUAT DATA MOBIL
        $mobil = Mobil::create($data);


        // FOTO TAMBAHAN
        foreach ($request->file('images', []) as $image) {

            if (!$image) {
                continue;
            }

            $mobil->images()->create([
                'gambar' => $this->upload($image),
            ]);
        }


        // WARNA
        $this->syncColors(
            $request,
            $mobil
        );


        return redirect()
            ->route('admin.mobil.index')
            ->with(
                'success',
                'Mobil berhasil ditambahkan.'
            );
    }


    public function edit($id)
    {
        $mobil = Mobil::with([
            'images',
            'colors',
        ])->findOrFail($id);


        return view(
            'admin.mobil.edit',
            compact('mobil')
        );
    }


    public function update(
        Request $request,
        $id
    ) {
        $mobil = Mobil::findOrFail($id);


        $data = $request->validate([

            'nama_mobil' => [
                'required',
                'string',
                'max:255',
            ],

            'merk' => [
                'required',
                'string',
                'max:255',
            ],

            'tahun' => [
                'required',
                'integer',
            ],

            'harga' => [
                'required',
                'numeric',
                'min:0',
            ],

            'stok' => [
                'required',
                'integer',
                'min:0',
            ],

            'deskripsi' => [
                'required',
            ],

            'gambar' => [
                'nullable',
                'image',
                'max:4096',
            ],

            'status' => [
                'nullable',
                'in:ready,booking,sold',
            ],

            'transmisi' => [
                'nullable',
                'string',
                'max:100',
            ],

            'bahan_bakar' => [
                'nullable',
                'string',
                'max:100',
            ],

            'warna' => [
                'nullable',
                'string',
                'max:255',
            ],

            'images.*' => [
                'nullable',
                'image',
                'max:4096',
            ],

            'colors' => [
                'nullable',
                'array',
            ],

            'colors.*.nama_warna' => [
                'nullable',
                'string',
                'max:100',
            ],

            'colors.*.kode_warna' => [
                'nullable',
                'string',
                'max:20',
            ],

            'colors.*.stok' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'colors.*.tersedia' => [
                'nullable',
            ],

        ]);


        // JIKA FOTO UTAMA DIGANTI
        if ($request->hasFile('gambar')) {

            $this->deleteFile(
                $mobil->gambar
            );

            $data['gambar'] = $this->upload(
                $request->file('gambar')
            );
        }


        // JANGAN MASUKKAN DATA ARRAY KE TABEL MOBIL
        unset(
            $data['images'],
            $data['colors']
        );


        // UPDATE DATA MOBIL
        $mobil->update($data);


        // TAMBAH FOTO TAMBAHAN BARU
        foreach ($request->file('images', []) as $image) {

            if (!$image) {
                continue;
            }

            $mobil->images()->create([
                'gambar' => $this->upload($image),
            ]);
        }


        // UPDATE WARNA
        $this->syncColors(
            $request,
            $mobil
        );


        return redirect()
            ->route('admin.mobil.index')
            ->with(
                'success',
                'Data mobil berhasil diperbarui.'
            );
    }


    public function destroy($id)
    {
        $mobil = Mobil::with([
            'images',
            'colors',
        ])->findOrFail($id);


        // HAPUS FOTO UTAMA
        $this->deleteFile(
            $mobil->gambar
        );


        // HAPUS FOTO TAMBAHAN
        foreach ($mobil->images as $image) {

            $this->deleteFile(
                $image->gambar
            );

            $image->delete();
        }


        // HAPUS DATA WARNA
        $mobil->colors()->delete();


        // HAPUS MOBIL
        $mobil->delete();


        return redirect()
            ->route('admin.mobil.index')
            ->with(
                'success',
                'Mobil berhasil dihapus.'
            );
    }


    public function destroyImage(
        MobilImage $image
    ) {
        $this->deleteFile(
            $image->gambar
        );

        $image->delete();


        return back()->with(
            'success',
            'Foto tambahan berhasil dihapus.'
        );
    }


    private function syncColors(
        Request $request,
        Mobil $mobil
    ) {
        // HAPUS WARNA LAMA
        $mobil->colors()->delete();


        // JIKA TIDAK ADA WARNA
        if (
            !is_array(
                $request->input('colors')
            )
        ) {
            return;
        }


        // SIMPAN WARNA BARU
        $totalColorStock = 0;

        foreach (
            $request->input('colors')
            as $color
        ) {

            if (
                empty(
                    $color['nama_warna']
                )
            ) {
                continue;
            }


            $stok = max(
                0,
                (int) (
                    $color['stok'] ?? 0
                )
            );


            $tersedia = !empty(
                $color['tersedia']
            ) && $stok > 0;


            $totalColorStock += $stok;

            $mobil->colors()->create([

                'nama_warna' =>
                    $color['nama_warna'],

                'kode_warna' =>
                    $color['kode_warna']
                    ?? '#888888',

                'stok' =>
                    $stok,

                'tersedia' =>
                    $tersedia,

            ]);
        }

        // Jika mobil memakai sistem warna, stok total mobil harus mengikuti
        // jumlah stok seluruh warna agar admin dan halaman user selalu sinkron.
        $mobil->update([
            'stok' => $totalColorStock,
        ]);
    }


    private function upload($file)
    {
        $directory = public_path(
            'uploads/mobil'
        );


        // BUAT FOLDER JIKA BELUM ADA
        if (!File::exists($directory)) {

            File::makeDirectory(
                $directory,
                0755,
                true
            );
        }


        $name =
            now()->format('YmdHis')
            . '-'
            . Str::random(8)
            . '.'
            . $file->extension();


        $file->move(
            $directory,
            $name
        );


        return $name;
    }


    private function deleteFile(
        ?string $filename
    ) {
        if (!$filename) {
            return;
        }


        $path = public_path(
            'uploads/mobil/' . $filename
        );


        if (File::exists($path)) {

            File::delete($path);
        }
    }
}