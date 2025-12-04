<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
// Import Controllers Utama
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\PageController; // Untuk rute statis (home, about, contact)
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\LapanganController as AdminLapanganController;


/*
|--------------------------------------------------------------------------
| 1. PUBLIC ROUTES (Dapat diakses tanpa login)
|--------------------------------------------------------------------------
*/

// Rute utama (Homepage)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Rute Halaman Statis (Menggunakan PageController)
Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

// Jika halaman Lapangan ingin dilihat tanpa login, pindahkan route di bawah ini ke sini.
// Namun, biasanya untuk booking butuh login, jadi saya biarkan di middleware 'auth'.

/*
|--------------------------------------------------------------------------
| 2. AUTHENTICATED USER ROUTES (Hanya bisa diakses setelah login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Dashboard User
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Profil User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Lapangan (Daftar Lapangan untuk Customer)
    // Berdasarkan struktur folder Anda: resources/views/customer/lapangan/index.blade.php
    Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');

    // Reservasi (Customer)
    // Berdasarkan struktur folder Anda: resources/views/customer/reservasi/create.blade.php
    Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    // Riwayat Reservasi Customer
    Route::get('/reservasi', [ReservasiController::class, 'index'])->name('reservasi.index');
});


/*
|--------------------------------------------------------------------------
| 3. ADMIN ROUTES (Hanya bisa diakses oleh Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Lapangan
    Route::resource('lapangan', AdminLapanganController::class);

    // Manajemen Reservasi
    Route::get('reservasi', [AdminReservasiController::class, 'index'])->name('reservasi.index');
    Route::patch('reservasi/{reservasi}/konfirmasi', [AdminReservasiController::class, 'confirm'])->name('reservasi.confirm');
    Route::patch('reservasi/{reservasi}/tolak', [AdminReservasiController::class, 'reject'])->name('reservasi.reject');
    
    // Manajemen User
    Route::resource('users', UserController::class)->only(['index', 'destroy']);
});

require __DIR__.'/auth.php';