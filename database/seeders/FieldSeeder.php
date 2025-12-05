<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    public function run(): void
    {
        $fields = [
            [
                'name' => 'Lapangan Vinyl A (Indoor)',
                'capacity' => 10,
                'hourly_rate' => 150000,
                'image' => 'field_images/lapangan_vinyl_a.jpg',
            ],
            [
                'name' => 'Lapangan Rumput Sintetis B',
                'capacity' => 12,
                'hourly_rate' => 180000,
                'image' => 'field_images/lapangan_rumput_sintetis_b.jpg',
            ],
            [
                'name' => 'Lapangan Semen C (Semi-Outdoor)',
                'capacity' => 10,
                'hourly_rate' => 120000,
                'image' => 'field_images/lapangan_semen_c.jpg',
            ],
        ];

        foreach ($fields as $field) {
            Field::create($field);
        }
    }
}
