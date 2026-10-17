<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Seeder;

class MobilSeeder extends Seeder
{
    public function run(): void
    {
        $mobils = [

            // =========================
            // TOYOTA
            // =========================
            [
                'nama_mobil' => 'Toyota Avanza',
                'merk' => 'Toyota',
                'tahun' => 2025,
                'harga' => 250000000,
                'gambar' => 'avanza.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Silver',
                'deskripsi' => 'Toyota Avanza, MPV keluarga yang nyaman, irit, dan cocok untuk penggunaan harian.',
            ],

            [
                'nama_mobil' => 'Toyota Innova Zenix',
                'merk' => 'Toyota',
                'tahun' => 2025,
                'harga' => 480000000,
                'gambar' => 'innova-zenix.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Black',
                'deskripsi' => 'Toyota Innova Zenix dengan desain modern dan kenyamanan premium untuk keluarga.',
            ],

            [
                'nama_mobil' => 'Toyota Fortuner',
                'merk' => 'Toyota',
                'tahun' => 2025,
                'harga' => 620000000,
                'gambar' => 'fortuner.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Diesel',
                'warna' => 'White',
                'deskripsi' => 'SUV premium Toyota dengan mesin bertenaga dan tampilan yang gagah.',
            ],


            // =========================
            // HONDA
            // =========================
            [
                'nama_mobil' => 'Honda Brio',
                'merk' => 'Honda',
                'tahun' => 2025,
                'harga' => 260000000,
                'gambar' => 'brio.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Yellow',
                'deskripsi' => 'City car sporty dan irit, cocok untuk penggunaan perkotaan.',
            ],

            [
                'nama_mobil' => 'Honda HR-V',
                'merk' => 'Honda',
                'tahun' => 2025,
                'harga' => 450000000,
                'gambar' => 'hrv.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'White',
                'deskripsi' => 'Compact SUV Honda dengan desain modern dan fitur lengkap.',
            ],

            [
                'nama_mobil' => 'Honda CR-V',
                'merk' => 'Honda',
                'tahun' => 2025,
                'harga' => 750000000,
                'gambar' => 'crv.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Black',
                'deskripsi' => 'SUV premium dengan kenyamanan tinggi dan performa bertenaga.',
            ],


            // =========================
            // MITSUBISHI
            // =========================
            [
                'nama_mobil' => 'Mitsubishi Xpander',
                'merk' => 'Mitsubishi',
                'tahun' => 2025,
                'harga' => 330000000,
                'gambar' => 'xpander.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Grey',
                'deskripsi' => 'MPV modern dengan desain sporty dan kabin luas untuk keluarga.',
            ],

            [
                'nama_mobil' => 'Mitsubishi Pajero Sport',
                'merk' => 'Mitsubishi',
                'tahun' => 2025,
                'harga' => 720000000,
                'gambar' => 'pajero-sport.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Diesel',
                'warna' => 'Black',
                'deskripsi' => 'SUV diesel premium dengan performa tangguh dan fitur modern.',
            ],


            // =========================
            // SUZUKI
            // =========================
            [
                'nama_mobil' => 'Suzuki Fronx',
                'merk' => 'Suzuki',
                'tahun' => 2025,
                'harga' => 320000000,
                'gambar' => 'fronx.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Blue',
                'deskripsi' => 'SUV compact dengan desain modern dan cocok untuk mobilitas perkotaan.',
            ],

            [
                'nama_mobil' => 'Suzuki XL7',
                'merk' => 'Suzuki',
                'tahun' => 2025,
                'harga' => 310000000,
                'gambar' => 'xl7.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'White',
                'deskripsi' => 'SUV keluarga dengan kabin lega dan desain yang sporty.',
            ],


            // =========================
            // HYUNDAI
            // =========================
            [
                'nama_mobil' => 'Hyundai Creta',
                'merk' => 'Hyundai',
                'tahun' => 2025,
                'harga' => 400000000,
                'gambar' => 'creta.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Red',
                'deskripsi' => 'SUV modern dengan desain futuristik dan fitur teknologi lengkap.',
            ],

            [
                'nama_mobil' => 'Hyundai Ioniq 5',
                'merk' => 'Hyundai',
                'tahun' => 2025,
                'harga' => 850000000,
                'gambar' => 'ioniq5.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'White',
                'deskripsi' => 'Mobil listrik premium dengan desain futuristik dan teknologi modern.',
            ],


            // =========================
            // WULING
            // =========================
            [
                'nama_mobil' => 'Wuling Alvez',
                'merk' => 'Wuling',
                'tahun' => 2025,
                'harga' => 310000000,
                'gambar' => 'alvez.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'White',
                'deskripsi' => 'SUV stylish dengan fitur modern dan harga kompetitif.',
            ],

            [
                'nama_mobil' => 'Wuling Binguo EV',
                'merk' => 'Wuling',
                'tahun' => 2025,
                'harga' => 380000000,
                'gambar' => 'binguo.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'Green',
                'deskripsi' => 'Mobil listrik dengan desain unik, modern, dan cocok untuk perkotaan.',
            ],


            // =========================
            // BYD
            // =========================
            [
                'nama_mobil' => 'BYD Atto 3',
                'merk' => 'BYD',
                'tahun' => 2025,
                'harga' => 550000000,
                'gambar' => 'byd-atto3.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'Blue',
                'deskripsi' => 'SUV listrik modern dengan teknologi tinggi dan jarak tempuh yang kompetitif.',
            ],

            [
                'nama_mobil' => 'BYD Seal',
                'merk' => 'BYD',
                'tahun' => 2025,
                'harga' => 650000000,
                'gambar' => 'byd-seal.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'Blue',
                'deskripsi' => 'Sedan listrik premium dengan performa tinggi dan desain sporty.',
            ],


            // =========================
            // CHERY
            // =========================
            [
                'nama_mobil' => 'Chery Omoda 5',
                'merk' => 'Chery',
                'tahun' => 2025,
                'harga' => 420000000,
                'gambar' => 'omoda5.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'White',
                'deskripsi' => 'SUV modern dengan desain futuristik dan fitur lengkap.',
            ],

            [
                'nama_mobil' => 'Chery Tiggo 8',
                'merk' => 'Chery',
                'tahun' => 2025,
                'harga' => 650000000,
                'gambar' => 'tiggo8.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Black',
                'deskripsi' => 'SUV premium dengan kabin luas dan kenyamanan tinggi.',
            ],


            // =========================
            // MAZDA
            // =========================
            [
                'nama_mobil' => 'Mazda CX-5',
                'merk' => 'Mazda',
                'tahun' => 2025,
                'harga' => 720000000,
                'gambar' => 'cx5.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Red',
                'deskripsi' => 'SUV premium dengan desain elegan dan pengalaman berkendara sporty.',
            ],


            // =========================
            // BMW
            // =========================
            [
                'nama_mobil' => 'BMW X1',
                'merk' => 'BMW',
                'tahun' => 2025,
                'harga' => 1100000000,
                'gambar' => 'bmw-x1.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'White',
                'deskripsi' => 'SUV premium BMW dengan desain mewah dan teknologi modern.',
            ],

            [
                'nama_mobil' => 'BMW iX1',
                'merk' => 'BMW',
                'tahun' => 2025,
                'harga' => 1500000000,
                'gambar' => 'bmw-ix1.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'Black',
                'deskripsi' => 'SUV listrik premium dari BMW dengan performa dan teknologi tinggi.',
            ],


            // =========================
            // MERCEDES BENZ
            // =========================
            [
                'nama_mobil' => 'Mercedes-Benz GLC',
                'merk' => 'Mercedes-Benz',
                'tahun' => 2025,
                'harga' => 1600000000,
                'gambar' => 'mercedes-glc.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Bensin',
                'warna' => 'Grey',
                'deskripsi' => 'SUV mewah dengan kenyamanan premium dan teknologi modern.',
            ],


            // =========================
            // TESLA
            // =========================
            [
                'nama_mobil' => 'Tesla Model 3',
                'merk' => 'Tesla',
                'tahun' => 2025,
                'harga' => 750000000,
                'gambar' => 'tesla-model3.jpg',
                'transmisi' => 'Automatic',
                'bahan_bakar' => 'Listrik',
                'warna' => 'White',
                'deskripsi' => 'Sedan listrik modern dengan performa tinggi dan teknologi canggih.',
            ],
        ];

        foreach ($mobils as $mobil) {
            Mobil::updateOrCreate(
                ['nama_mobil' => $mobil['nama_mobil']],
                $mobil
            );
        }
    }
}