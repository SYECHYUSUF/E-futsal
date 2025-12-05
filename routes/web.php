<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\ReservationController as CustomerReservationController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReservationController as AdminReservationController;
use App\Http\Controllers\Admin\FieldController as AdminFieldController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/about-us', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/fields', [FieldController::class, 'index'])->name('customer.fields.index');

    Route::get('/reservations/create', [CustomerReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [CustomerReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [CustomerReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [CustomerReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}/payment', [CustomerReservationController::class, 'uploadPayment'])->name('reservations.payment');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('fields', AdminFieldController::class);

    Route::delete('gallery/{galleryId}', [AdminFieldController::class, 'deleteGallery'])->name('fields.gallery.delete');
    Route::patch('fields/{field}/gallery', [AdminFieldController::class, 'updateGallery'])->name('fields.gallery.update');
    Route::patch('fields/{field}/facilities', [AdminFieldController::class, 'updateFacilities'])->name('fields.facilities.update');

    Route::get('reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::patch('reservations/{reservation}/approve', [AdminReservationController::class, 'approve'])->name('reservations.approve');
    Route::patch('reservations/{reservation}/reject', [AdminReservationController::class, 'reject'])->name('reservations.reject');

    Route::resource('users', UserController::class)->only(['index', 'destroy']);

    Route::patch('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
});

require __DIR__ . '/auth.php';
