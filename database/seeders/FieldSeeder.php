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
            // Lapangan Vinyl (Standar Kompetisi)
            [
                'name' => 'Lapangan Vinyl Pro',
                'capacity' => 10,
                'hourly_rate' => 150000,
                // Gambar: Lapangan Indoor Lantai Biru/Hijau
                'image' => 'https://smartcity.gowakab.go.id/frontend/olahraga_img/1650861170_1159654084.jpg',
            ],
            // Lapangan Rumput Sintetis (Favorit)
            [
                'name' => 'Lapangan Rumput Sintetis',
                'capacity' => 12,
                'hourly_rate' => 180000,
                // Gambar: Tekstur Rumput Hijau
                'image' => 'https://jasakontraktorlapangan.id/wp-content/uploads/2023/02/Jasa-Pembuatan-Lapangan-Futsal-Makassar.jpeg',
            ],
            // Lapangan Semen (Street Futsal)
            [
                'name' => 'Lapangan Semen',
                'capacity' => 10,
                'hourly_rate' => 100000,
                // Gambar: Lapangan Outdoor/Jalanan
                'image' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT-VQg84mTh--gup_2WReoPrcr3eNEFopyS3Q&s',
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