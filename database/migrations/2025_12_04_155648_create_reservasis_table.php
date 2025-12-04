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
    Schema::create('reservasi', function (Blueprint $table) {
        $table->id();
        $table->foreignId('lapangan_id')->constrained('lapangan')->onDelete('cascade');
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->date('date');
        $table->time('start_time');
        $table->time('end_time');
        $table->unsignedInteger('duration_hours');
        $table->unsignedBigInteger('total_price');
        $table->enum('status', ['pending', 'confirmed', 'paid', 'cancelled'])->default('pending');
        $table->text('note')->nullable(); // Dari file migrasi tambahan Anda
        $table->timestamps();

        $table->index(['date', 'start_time', 'end_time']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservasis');
    }
};
