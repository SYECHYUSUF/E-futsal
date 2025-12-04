<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Akun ADMIN
        User::create([
            'name' => 'Admin Futsal',
            'email' => 'admin@futsal.com',
            'phone' => '081234567890', // Pastikan kolom phone ada
            'password' => Hash::make('password'), // Password default: password
            'is_admin' => true, // Menandakan dia admin
            'email_verified_at' => now(),
        ]);

        // 2. Buat Akun CUSTOMER (User Biasa)
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'user@futsal.com',
            'phone' => '089876543210',
            'password' => Hash::make('password'),
            'is_admin' => false, // Menandakan dia user biasa
            'email_verified_at' => now(),
        ]);

        // 3. (Opsional) Buat 5 User Acak Tambahan
        User::factory(5)->create();
    }
}