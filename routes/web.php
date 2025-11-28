<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KostController;
use App\Http\Controllers\PencariController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Route Home (Pintu Pembagi Nasib)
Route::get('/home', function () {
    $role = Auth::user()->role;

    if ($role == 'pemilik') {
        // Calculate totals for pemilik dashboard
        $total_kosts = \App\Models\Kos::where('pemilik_id', Auth::id())->count();
        $total_kamar_kosong = \App\Models\Kos::where('pemilik_id', Auth::id())->sum('jumlah_kamar_kosong');
        $total_kamar = \App\Models\Kos::where('pemilik_id', Auth::id())->sum('jumlah_kamar_total');
        return view('home', compact('total_kosts', 'total_kamar_kosong', 'total_kamar')); // Dashboard Pemilik (View lama)
    } elseif ($role == 'pencari') {
        return redirect()->route('pencari.index'); // Lempar ke Katalog
    }
})->name('home');

// Group Route khusus yang sudah Login
Route::middleware(['auth'])->group(function () {

    // Route Profil
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [AuthController::class, 'updatePassword'])->name('profile.updatePassword');

    // Route buat Pemilik (CRUD Kost)
    Route::resource('kost', KostController::class);

    // Route buat Pencari (Katalog & Detail)
    Route::get('/jelajah', [PencariController::class, 'index'])->name('pencari.index');
    Route::get('/jelajah/{id}', [PencariController::class, 'show'])->name('pencari.show');
    Route::get('/pencari/dashboard', [PencariController::class, 'dashboard'])->name('pencari.dashboard');

    // Booking & Pembayaran untuk Pencari
    Route::get('/booking/{kamar_id}', [\App\Http\Controllers\BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [\App\Http\Controllers\BookingController::class, 'store'])->name('booking.store');

    Route::get('/booking/{booking_id}/bayar', [\App\Http\Controllers\PembayaranController::class, 'create'])->name('pembayaran.create');
    Route::post('/booking/{booking_id}/bayar', [\App\Http\Controllers\PembayaranController::class, 'store'])->name('pembayaran.store');

    // Ulasan
    Route::post('/ulasan', [\App\Http\Controllers\UlasanController::class, 'store'])->name('ulasan.store');

    // Route untuk Kamar (nested dengan kost)
    Route::get('/kost/{kos_id}/kamar', [\App\Http\Controllers\KamarController::class, 'index'])->name('pemilik.kamar.index');
    Route::get('/kost/{kos_id}/kamar/create', [\App\Http\Controllers\KamarController::class, 'create'])->name('pemilik.kamar.create');
    Route::post('/kost/{kos_id}/kamar', [\App\Http\Controllers\KamarController::class, 'store'])->name('pemilik.kamar.store');
    Route::get('/kost/{kos_id}/kamar/{kamar_id}/edit', [\App\Http\Controllers\KamarController::class, 'edit'])->name('pemilik.kamar.edit');
    Route::put('/kost/{kos_id}/kamar/{kamar_id}', [\App\Http\Controllers\KamarController::class, 'update'])->name('pemilik.kamar.update');
    Route::delete('/kost/{kos_id}/kamar/{kamar_id}', [\App\Http\Controllers\KamarController::class, 'destroy'])->name('pemilik.kamar.destroy');

    // Route untuk Foto Kamar
    Route::post('/kost/{kos_id}/kamar/{kamar_id}/foto', [\App\Http\Controllers\FotoKamarController::class, 'store'])->name('pemilik.foto.store');
    Route::delete('/foto/{foto_id}', [\App\Http\Controllers\FotoKamarController::class, 'destroy'])->name('pemilik.foto.destroy');

    // Route untuk Fasilitas Kos
    Route::get('/kost/{kos_id}/fasilitas', [\App\Http\Controllers\FasilitasController::class, 'index'])->name('pemilik.fasilitas.index');
    Route::post('/kost/{kos_id}/fasilitas/attach', [\App\Http\Controllers\FasilitasController::class, 'attach'])->name('pemilik.fasilitas.attach');
    Route::delete('/kost/{kos_id}/fasilitas/{fasilitas_id}', [\App\Http\Controllers\FasilitasController::class, 'detach'])->name('pemilik.fasilitas.detach');
});
// ... kode route yang lain biarkan di atas ...

// --- ALAT PENDETEKSI ERROR FOTO (Hapus nanti kalau udah beres) ---
Route::get('/cek-foto', function () {
    // 1. Ambil data kost paling baru
    $kost = \App\Models\Kos::latest()->first();

    if(!$kost) {
        return "Belum ada data kost! Input dulu satu data baru sebagai Pemilik.";
    }

    // 2. Cek apakah nama file tersimpan di database
    $namaFile = $kost->foto;
    if(!$namaFile) {
        return "ERROR: Kolom foto di database KOSONG (NULL). Pastikan input data baru, jangan edit data lama.";
    }

    // 3. Cek apakah file fisiknya beneran ada di folder penyimpanan rahasia (storage/app/public)
    $pathAsli = storage_path('app/public/' . $namaFile);
    $fileAsliAda = file_exists($pathAsli);

    // 4. Cek apakah 'Jalan Pintas' (symlink) di folder public sudah benar
    $pathPublic = public_path('storage/' . $namaFile);
    $linkAda = file_exists($pathPublic);

    return [
        'STATUS' => 'Laporan Detektif Foto',
        '1. Nama File di Database' => $namaFile,
        '2. Cek File di Folder Asli (Storage)' => $fileAsliAda ? 'ADA (Aman) ✅' : 'TIDAK ADA (Gawat) ❌',
        '3. Cek File di Folder Public (Link)' => $linkAda ? 'ADA (Aman) ✅' : 'TIDAK ADA (Link Putus) ❌',
        '4. Link URL yang dipakai' => asset('storage/' . $namaFile),
        '5. Pesan untuk King' => (!$fileAsliAda) ? 'File tidak ter-upload. Cek folder storage/app/public/kost-images.' : ((!$linkAda) ? 'Masalah di storage:link. Hapus folder public/storage dan link ulang.' : 'Semua terlihat aman. Coba clear cache browser.')
    ];
});
