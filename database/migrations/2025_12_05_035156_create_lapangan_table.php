<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Secara default Laravel menggunakan nama jamak (lapangans)
        // Tapi error kamu mencari 'lapangan', jadi kita bisa pakai nama tabel singular
        // atau nanti kita sesuaikan di Model. Di sini saya pakai standar Laravel (plural).
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('kapasitas'); // Sesuai error: 10
            $table->decimal('biaya_per_jam', 10, 2); // Sesuai error: 150000
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};