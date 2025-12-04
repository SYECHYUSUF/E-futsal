<?php

use App\Http\Controllers\ProfileController;
// Controller Halaman Statis (Baru)
use App\Http\Controllers\PageController;
// Controller Customer
use App\Http\Controllers\Customer\ReservasiController as CustomerReservasiController;
use App\Http\Controllers\Customer\LapanganController as CustomerLapanganController;
// Controller Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganController as AdminLapanganController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
// Facades
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini mengatur seluruh jalur URL aplikasi eFutsal.
|
*/

// --- 1. HALAMAN PUBLIK (Bisa diakses tanpa login) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');


// --- 2. PENGARAH DASHBOARD (REDIRECTOR) ---
// Logika: Setelah login, cek role user lalu arahkan ke halaman yang sesuai.
Route::get('/dashboard', function () {
    /** @var \App\Models\User $user */
    $user = Auth::user();

    // Jika Admin (is_admin = 1), ke Dashboard Admin
    if ($user && $user->is_admin) {
        return redirect()->route('admin.dashboard');
    }
    
    // Jika User Biasa (is_admin = 0), ke Halaman Reservasi Saya
    return redirect()->route('reservasi.index'); 
})->middleware(['auth', 'verified'])->name('dashboard');


// --- 3. AREA CUSTOMER (User yang sudah login) ---
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Lihat Daftar Lapangan
    Route::get('/lapangan', [CustomerLapanganController::class, 'index'])
        ->name('lapangan.index');
    
    // --- MENU RESERVASI ---

    // [BARU] Route AJAX untuk Cek Ketersediaan (Tanpa Reload)
    // Penting: Diletakkan sebelum route yang pakai {parameter} agar tidak tertukar
    Route::get('/reservasi/check', [CustomerReservasiController::class, 'checkAvailability'])
        ->name('reservasi.check');
    
    // History Booking
    Route::get('/reservasi', [CustomerReservasiController::class, 'index'])
        ->name('reservasi.index'); 
    
    // Form Booking
    Route::get('/reservasi/create', [CustomerReservasiController::class, 'create'])
        ->name('reservasi.create'); 
    
    // Proses Simpan
    Route::post('/reservasi', [CustomerReservasiController::class, 'store'])
        ->name('reservasi.store'); 
    
    // --- Route Approval via WhatsApp (GET Request) ---
    Route::get('/reservasi/{id}/approve', [CustomerReservasiController::class, 'approve'])
        ->name('reservasi.approve');
    Route::get('/reservasi/{id}/reject', [CustomerReservasiController::class, 'reject'])
        ->name('reservasi.reject');
    
    // Pengaturan Profil (Bawaan Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// --- 4. AREA ADMIN (Khusus Role Admin) ---
// Middleware 'admin' wajib ada di kernel (bootstrap/app.php)
Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Statistik
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Manajemen Lapangan (CRUD)
    Route::resource('lapangan', AdminLapanganController::class);

    // Manajemen Reservasi (Halaman Admin)
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])
        ->name('reservasi.index');

    // === PAGE KHUSUS REVIEW DARI WA (Opsional jika ingin detail view) ===
    Route::get('/reservasi/{reservasi}/review', [AdminReservasiController::class, 'review'])
        ->name('reservasi.review');

    // Tombol Aksi di Dashboard Admin (Biasanya berupa Form POST)
    Route::post('/reservasi/{reservasi}/approve', [AdminReservasiController::class, 'approve'])
        ->name('reservasi.approve');
    Route::post('/reservasi/{reservasi}/reject', [AdminReservasiController::class, 'reject'])
        ->name('reservasi.reject');
});

// Memuat route otentikasi (Login, Register, dll)
require __DIR__.'/auth.php';