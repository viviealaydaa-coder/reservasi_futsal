<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LapanganAdminController;
use App\Http\Controllers\Admin\BookingAdminController;
use App\Http\Controllers\Admin\KeuanganController;

// Halaman publik
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/lapangans', [LapanganController::class, 'index'])->name('lapangans.index');

Route::get('/lapangans/{id}', [LapanganController::class, 'show'])->name('lapangans.show');

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Booking (login required)
Route::middleware('auth')->group(function () {

    Route::get('/booking/create/{lapangan_id}', [BookingController::class, 'create'])->name('bookings.create');

    Route::post('/booking/store', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/booking/payment/{id}', [BookingController::class, 'paymentPage'])->name('bookings.payment');

    Route::post('/booking/upload-proof/{id}', [BookingController::class, 'uploadProof'])->name('bookings.uploadProof');

    Route::get('/bookings/history', [BookingController::class, 'history'])->name('bookings.history');

    Route::get('/booking/invoice/{id}', [BookingController::class, 'invoice'])->name('booking.invoice');

    // cek slot
    Route::get('/check-slot', [BookingController::class, 'checkSlot'])->name('check.slot');

    // cancel booking user
    Route::post('/booking/cancel-user/{id}', [BookingController::class, 'cancelByUser'])->name('bookings.cancelByUser');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('lapangans', LapanganAdminController::class)->except(['show']);

    Route::delete('/lapangan-photo/{photoId}', [LapanganAdminController::class, 'deletePhoto'])->name('lapangan.deletePhoto');

    Route::post('/lapangans/{id}/toggle-status', [LapanganAdminController::class, 'toggleStatus'])->name('lapangans.toggleStatus');

    Route::get('/bookings', [BookingAdminController::class, 'index'])->name('bookings.index');

    Route::post('/booking/verify/{id}', [BookingAdminController::class, 'verifyPayment'])->name('booking.verify');

    Route::post('/booking/reject/{id}', [BookingAdminController::class, 'rejectPayment'])->name('booking.reject');

    Route::post('/booking/complete/{id}', [BookingAdminController::class, 'completeBooking'])->name('booking.complete');

    Route::post('/booking/cancel/{id}', [BookingAdminController::class, 'cancelBooking'])->name('booking.cancel');

    Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan');

    Route::get('/keuangan/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.pdf');

    Route::get('/laporan/transaksi', [App\Http\Controllers\Admin\LaporanController::class, 'transaksi'])->name('laporan.transaksi');
});

// laporan navbar
Route::middleware(['auth', 'admin'])->get('/laporan-keuangan', [KeuanganController::class, 'index'])->name('laporan.keuangan');

// RESET ADMIN PASSWORD
Route::get('/reset-admin', function () {

    $user = User::where('email', 'admin@futsal.com')->first();

    if ($user) {

        $user->password = Hash::make('admin123');
        $user->save();

        return 'Password berhasil direset';
    }

    return 'User tidak ditemukan';
});

// CEK USER
Route::get('/cek-user', function () {

    return User::all();
});

Route::get('/test', function () {
    return 'Railway hidup';
});