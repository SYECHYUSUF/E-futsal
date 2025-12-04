<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Gunakan "reservasis" (plural)
        Schema::create('reservasis', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel 'users' dan 'lapangans'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lapangan_id')->constrained('lapangans')->onDelete('cascade');
            
            // Kolom Data (Bahasa Indonesia sesuai Controller)
            $table->date('tanggal_main');     // Sebelumnya 'date'
            $table->time('jam_mulai');        // Sebelumnya 'start_time'
            $table->time('jam_selesai');      // Sebelumnya 'end_time'
            $table->integer('durasi');        // Sebelumnya 'duration_hours'
            $table->bigInteger('total_harga'); // Sebelumnya 'total_price'
            
            $table->enum('status', ['pending', 'confirmed', 'paid', 'cancelled', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};