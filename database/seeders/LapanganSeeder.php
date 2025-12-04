<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class LapanganSeeder extends Seeder
{
    public function run(): void
    {
        $lapangans = [
            [
                'nama' => 'Lapangan Vinyl A (Indoor)',
                'kapasitas' => 10,
                'biaya_per_jam' => 150000,
                'gambar' => 'lapangan_images/lapangan_lapangan_vinyl_a__indoor_.jpg',
            ],
            [
                'nama' => 'Lapangan Rumput Sintetis B',
                'kapasitas' => 12,
                'biaya_per_jam' => 180000,
                'gambar' => 'lapangan_images/lapangan_lapangan_rumput_sintetis_b.jpg',
            ],
            [
                'nama' => 'Lapangan Semen C (Semi-Outdoor)',
                'kapasitas' => 10,
                'biaya_per_jam' => 120000,
                'gambar' => 'lapangan_images/lapangan_lapangan_semen_c__semi-outdoor_.jpg',
            ],
        ];

        foreach ($lapangans as $lapangan) {
            Lapangan::create($lapangan); //
        }
    }
}