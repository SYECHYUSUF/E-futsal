<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            // Pastikan constrained mengarah ke tabel 'users' dan 'fields'
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('field_id')->constrained('fields')->onDelete('cascade');

            // Kolom yang sudah diubah ke Bahasa Inggris
            $table->date('booking_date')->nullable(); // Sebelumnya: tanggal_booking
            $table->time('start_time')->nullable();   // Sebelumnya: jam_mulai
            $table->time('end_time')->nullable();     // Sebelumnya: jam_selesai

            $table->decimal('total_price', 10, 2)->default(0);
            $table->enum('status', ['pending', 'paid', 'confirmed'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
