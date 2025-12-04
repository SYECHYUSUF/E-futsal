<?php

namespace Database\Seeders;

use App\Models\Lapangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LapanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Bersihkan data lama agar tidak duplikat (opsional)
        // Lapangan::truncate(); 

        // 2. Siapkan Folder Penyimpanan Gambar
        // Path: storage/app/public/lapangan_images
        $path = 'public/lapangan_images';
        
        if (!Storage::exists($path)) {
            Storage::makeDirectory($path);
        }

        // 3. Data Lapangan Dummy
        $dataLapangan = [
            [
                'nama' => 'Lapangan Vinyl A (Indoor)',
                'deskripsi' => 'Lapangan dengan lantai vinyl standar internasional, cocok untuk permainan cepat. Full AC dan penerangan LED.',
                'kapasitas' => 10,
                'biaya_per_jam' => 150000,
                'gambar_url' => 'https://placehold.co/800x600/2563eb/ffffff.jpg?text=Vinyl+A', // Dummy Image
            ],
            [
                'nama' => 'Lapangan Rumput Sintetis B',
                'deskripsi' => 'Rumput sintetis kualitas premium yang empuk, aman untuk jatuh. Cocok untuk main santai.',
                'kapasitas' => 12,
                'biaya_per_jam' => 120000,
                'gambar_url' => 'https://placehold.co/800x600/16a34a/ffffff.jpg?text=Rumput+B',
            ],
            [
                'nama' => 'Lapangan Semen C (Semi-Outdoor)',
                'deskripsi' => 'Lapangan lantai semen halus semi-outdoor. Sirkulasi udara alami, harga lebih ekonomis.',
                'kapasitas' => 10,
                'biaya_per_jam' => 80000,
                'gambar_url' => 'https://placehold.co/800x600/ea580c/ffffff.jpg?text=Semen+C',
            ],
        ];

        // 4. Proses Download Gambar & Simpan ke Database
        foreach ($dataLapangan as $item) {
            // Generate nama file unik
            $filename = 'lapangan_' . strtolower(str_replace([' ', '(', ')', '/'], '_', $item['nama'])) . '.jpg';
            $storagePath = $path . '/' . $filename;

            // Cek apakah gambar sudah ada di storage? Kalau belum, download dari URL dummy
            if (!Storage::exists($storagePath)) {
                try {
                    $contents = file_get_contents($item['gambar_url']);
                    Storage::put($storagePath, $contents);
                    $this->command->info("Gambar berhasil didownload: " . $filename);
                } catch (\Exception $e) {
                    $this->command->warn("Gagal download gambar untuk: " . $item['nama'] . ". Menggunakan default.");
                    $filename = null; // Atau set ke default image jika ada
                }
            } else {
                $this->command->info("Gambar sudah ada: " . $filename);
            }

            // Simpan ke Database
            // Path yang disimpan di DB adalah relative path untuk 'storage/' link
            // Contoh: lapangan_images/lapangan_a.jpg
            Lapangan::create([
                'nama' => $item['nama'],
                // Hapus 'deskripsi' jika kolom tersebut belum ada di migrasi Anda (saya lihat di file migrasi sebelumnya belum ada deskripsi, tapi boleh ditambah jika perlu)
                // 'deskripsi' => $item['deskripsi'], 
                'kapasitas' => $item['kapasitas'],
                'biaya_per_jam' => $item['biaya_per_jam'],
                'gambar' => 'lapangan_images/' . $filename,
            ]);
        }
    }
}