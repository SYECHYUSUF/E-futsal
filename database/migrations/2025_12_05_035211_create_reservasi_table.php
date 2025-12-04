<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();
            // Menghubungkan dengan tabel users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            // Menghubungkan dengan tabel lapangan
            $table->foreignId('lapangan_id')->constrained('lapangan')->onDelete('cascade'); 
            
            $table->date('tanggal_booking')->nullable();
            $table->time('jam_mulai')->nullable();
            $table->time('jam_selesai')->nullable();
            
            // Kolom penting berdasarkan error dashboard controller kamu
            $table->decimal('total_price', 10, 2)->default(0); 
            $table->string('status')->default('pending'); // pending, paid, confirmed
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};