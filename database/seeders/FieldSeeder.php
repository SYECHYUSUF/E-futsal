<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            // 1. Lapangan Vinyl (Standar Kompetisi)
            [
                'name' => 'Lapangan A - Vinyl Pro (Indoor)',
                'capacity' => 10,
                'hourly_rate' => 150000,
                // Gambar: Lapangan Indoor Lantai Biru/Hijau
                'image' => 'https://images.unsplash.com/photo-1518605348400-4377d639eda8?q=80&w=1000&auto=format&fit=crop',
            ],
            // 2. Lapangan Rumput Sintetis (Favorit)
            [
                'name' => 'Lapangan B - Rumput Sintetis',
                'capacity' => 12,
                'hourly_rate' => 180000,
                // Gambar: Tekstur Rumput Hijau
                'image' => 'https://images.unsplash.com/photo-1529900748604-07564a03e7a6?q=80&w=1000&auto=format&fit=crop',
            ],
            // 3. Lapangan Semen (Street Futsal)
            [
                'name' => 'Lapangan C - Street Court (Outdoor)',
                'capacity' => 10,
                'hourly_rate' => 100000,
                // Gambar: Lapangan Outdoor/Jalanan
                'image' => 'https://images.unsplash.com/photo-1552667466-07770ae110d0?q=80&w=1000&auto=format&fit=crop',
            ],
            // 4. Lapangan Interlock (Lantai Puzzle Modern)
            [
                'name' => 'Lapangan D - Interlock Premium',
                'capacity' => 10,
                'hourly_rate' => 160000,
                // Gambar: Futsal Indoor Modern
                'image' => 'https://images.unsplash.com/photo-1574629810360-7efbbe195018?q=80&w=1000&auto=format&fit=crop',
            ],
            // 5. Lapangan VIP (Private & Luas)
            [
                'name' => 'Lapangan E - VIP Arena',
                'capacity' => 14,
                'hourly_rate' => 250000,
                // Gambar: Stadium/Arena Besar
                'image' => 'https://images.unsplash.com/photo-1517927033932-b3d18e61fb3a?q=80&w=1000&auto=format&fit=crop',
            ],
            // 6. Lapangan Training (Kecil/Mini)
            [
                'name' => 'Lapangan F - Mini Training',
                'capacity' => 6,
                'hourly_rate' => 80000,
                // Gambar: Gawang Kecil/Latihan
                'image' => 'https://images.unsplash.com/photo-1543351611-58f69d7c1781?q=80&w=1000&auto=format&fit=crop',
            ],
        ];

        foreach ($fields as $field) {
            Field::updateOrCreate(
                ['name' => $field['name']], // Mencegah duplikat berdasarkan nama
                $field
            );
        }
    }
}