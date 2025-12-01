<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\PencariController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\FotoKamarController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PemilikController;
use App\Http\Controllers\PemilikBookingController;
use App\Http\Controllers\PemilikReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ========== HALAMAN PUBLIK ==========
Route::get('/', function () {
    return view('welcome');
});

// ========== AUTHENTICATION ROUTES ==========
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ========== HOME ROUTE (Fallback untuk backward compatibility) ==========
Route::get('/home', function () {
    if (!Auth::check()) {
        return redirect('/login');
    }

    $role = Auth::user()->role;
    if ($role == 'pemilik') {
        return redirect()->route('pemilik.dashboard');
    } elseif ($role == 'pencari') {
        return redirect()->route('pencari.index');
    }
    return redirect('/');
})->middleware('auth')->name('home');

// ========== AUTHENTICATED ROUTES ==========
Route::middleware(['auth'])->group(function () {

    // ===== PROFIL ROUTES =====
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');

    // ===== PENCARI ROUTES (JALUR PENCARI KOS) =====
    Route::prefix('pencari')->name('pencari.')->group(function () {
        // Katalog Kos
        Route::get('/jelajah', [PencariController::class, 'index'])->name('index');
        Route::get('/search', [PencariController::class, 'search'])->name('search');
        Route::get('/kos/{id}', [PencariController::class, 'show'])->name('show');

        // Dashboard Pencari
        Route::get('/dashboard', [PencariController::class, 'dashboard'])->name('dashboard');

        // Booking
        Route::get('/booking/{kamar_id}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/check-availability', [BookingController::class, 'checkAvailability'])->name('booking.checkAvailability');
        Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');
        Route::post('/booking/{booking_id}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');

        // Pembayaran
        Route::get('/booking/{booking_id}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/booking/{booking_id}/bayar', [PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/booking/{booking_id}/confirmation', [PembayaranController::class, 'confirmation'])->name('pembayaran.confirmation');

        // Ulasan
        Route::get('/booking/{booking_id}/ulasan', [UlasanController::class, 'create'])->name('ulasan.create');
        Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
        Route::get('/kos/{kos_id}/reviews', [UlasanController::class, 'kosReviews'])->name('reviews');
        Route::delete('/ulasan/{ulasan_id}', [UlasanController::class, 'destroy'])->name('ulasan.destroy');
    });

    // ===== PEMILIK ROUTES (JALUR PEMILIK KOS) =====
    Route::prefix('pemilik')->name('pemilik.')->middleware('auth')->group(function () {
        // Dashboard Pemilik
        Route::get('/dashboard', [PemilikController::class, 'dashboard'])->name('dashboard');

        // CRUD Kos
        Route::resource('kos', KostController::class);

        // Kamar Management (Nested routes)
        Route::get('/kos/{kos_id}/kamar', [KamarController::class, 'index'])->name('kamar.index');
        Route::get('/kos/{kos_id}/kamar/create', [KamarController::class, 'create'])->name('kamar.create');
        Route::post('/kos/{kos_id}/kamar', [KamarController::class, 'store'])->name('kamar.store');
        Route::get('/kos/{kos_id}/kamar/{kamar_id}/edit', [KamarController::class, 'edit'])->name('kamar.edit');
        Route::put('/kos/{kos_id}/kamar/{kamar_id}', [KamarController::class, 'update'])->name('kamar.update');
        Route::delete('/kos/{kos_id}/kamar/{kamar_id}', [KamarController::class, 'destroy'])->name('kamar.destroy');
        Route::patch('/kamar/{kamar_id}/status', [KamarController::class, 'updateStatus'])->name('kamar.updateStatus');

        // Foto Kamar Management
        Route::post('/kos/{kos_id}/kamar/{kamar_id}/foto', [FotoKamarController::class, 'store'])->name('foto.store');
        Route::delete('/foto/{foto_id}', [FotoKamarController::class, 'destroy'])->name('foto.destroy');

        // Fasilitas Management
        Route::get('/kos/{kos_id}/fasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');
        Route::post('/kos/{kos_id}/fasilitas/attach', [FasilitasController::class, 'attach'])->name('fasilitas.attach');
        Route::delete('/kos/{kos_id}/fasilitas/{fasilitas_id}', [FasilitasController::class, 'detach'])->name('fasilitas.detach');

        // Booking Management (Lihat booking masuk)
        Route::get('/bookings', [\App\Http\Controllers\PemilikBookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking_id}', [\App\Http\Controllers\PemilikBookingController::class, 'show'])->name('bookings.show');
        Route::post('/bookings/{booking_id}/confirm', [\App\Http\Controllers\PemilikBookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{booking_id}/reject', [\App\Http\Controllers\PemilikBookingController::class, 'reject'])->name('bookings.reject');

        // Ulasan Management (Lihat ulasan)
        Route::get('/reviews', [\App\Http\Controllers\PemilikReviewController::class, 'index'])->name('reviews.index');
        Route::get('/reviews/{kos_id}', [\App\Http\Controllers\PemilikReviewController::class, 'show'])->name('reviews.show');

        // Pembayaran Summary
        Route::get('/pembayaran', [PembayaranController::class, 'index'])->name('pembayaran.index');
    });

});

// ========== DEBUG ROUTES (Hapus setelah deploy) ==========
Route::get('/cek-foto', function () {
    $kost = \App\Models\Kos::latest()->first();
    if(!$kost) {
        return "Belum ada data kost! Input dulu satu data baru sebagai Pemilik.";
    }
    $namaFile = $kost->foto;
    if(!$namaFile) {
        return "ERROR: Kolom foto di database KOSONG (NULL).";
    }
    $pathAsli = storage_path('app/public/' . $namaFile);
    $fileAsliAda = file_exists($pathAsli);
    $pathPublic = public_path('storage/' . $namaFile);
    $linkAda = file_exists($pathPublic);
    return [
        'STATUS' => 'Laporan Detektif Foto',
        '1. Nama File di Database' => $namaFile,
        '2. Cek File di Folder Asli (Storage)' => $fileAsliAda ? 'ADA (Aman) ✅' : 'TIDAK ADA (Gawat) ❌',
        '3. Cek File di Folder Public (Link)' => $linkAda ? 'ADA (Aman) ✅' : 'TIDAK ADA (Link Putus) ❌',
        '4. Link URL yang dipakai' => asset('storage/' . $namaFile),
        '5. Pesan untuk King' => (!$fileAsliAda) ? 'File tidak ter-upload.' : ((!$linkAda) ? 'Masalah di storage:link.' : 'Semua aman.')
    ];
});
