# Spesifikasi Teknis: Aplikasi Booking Kos UNESA Magetan

## 1. Pendahuluan
Dokumen ini menguraikan spesifikasi teknis untuk pengembangan aplikasi web **"Booking Kos UNESA Magetan"**. Aplikasi ini berfungsi sebagai platform yang menghubungkan **Pemilik Kos** dengan **Pencari Kos** di sekitar area Kampus 5 UNESA Magetan.

Aplikasi ini akan dibangun sebagai aplikasi **monolitik** menggunakan **Laravel**, yang akan menangani *backend* (API logic) dan *frontend* (Blade views).

---

## 2. Tumpukan Teknologi (*Tech Stack*)

* **Platform:** Aplikasi Web
* **Framework Backend:** Laravel
* **Framework Frontend:** Laravel Blade (dengan JavaScript/AJAX untuk interaktivitas)
* **Database:** MySQL (Nama DB: `kost_db`)
* **Arsitektur:** Monolitik dengan *API-driven routes* untuk interaksi frontend tertentu.

---

## 3. Struktur Database
Struktur database didefinisikan dengan **10 tabel utama** yang mencakup manajemen pengguna, properti kos, kamar, fasilitas, booking, pembayaran, dan ulasan. Skema ini menjadi dasar untuk *migration* dan *model* di Laravel.

---

## 4. Fitur Utama

Fitur-fitur sistem dibagi berdasarkan dua peran pengguna utama:

### A. Fitur untuk Pencari Kos (User)
1.  **Autentikasi:** Mendaftar dan login sebagai 'pencari'.
2.  **Eksplorasi:**
    * Melihat daftar kos di halaman utama (dapat difokuskan di sekitar UNESA Magetan).
    * Melihat detail kos (deskripsi, fasilitas umum, ulasan, dan daftar kamar).
    * Melihat detail kamar (harga, ketersediaan, fasilitas kamar, foto).
3.  **Pencarian & Filter:**
    * Mencari kos berdasarkan nama.
    * Memfilter kos berdasarkan:
        * Tipe Kos (Putra, Putri, Campur)
        * Rentang Harga
        * Fasilitas (Umum/Kamar)
4.  **Booking:**
    * Melakukan booking kamar untuk rentang tanggal tertentu.
    * Melihat total harga.
    * Melihat riwayat booking (*pending, confirmed, completed*).
5.  **Pembayaran:** Melakukan pembayaran untuk booking yang telah dibuat (status berubah dari *pending* ke *confirmed* setelah pembayaran berhasil).
6.  **Ulasan:** Memberikan ulasan (rating & komentar) setelah booking selesai (*completed*).

### B. Fitur untuk Pemilik Kos (Owner)
1.  **Autentikasi:** Mendaftar dan login sebagai 'pemilik'.
2.  **Dashboard:** Halaman utama untuk mengelola semua kos yang dimiliki.
3.  **Manajemen Kos (CRUD):**
    * Menambahkan data kos baru (nama, alamat, deskripsi, tipe, lokasi lat/long).
    * Mengedit data kos.
    * Menghapus data kos.
    * Menghubungkan fasilitas umum ke kos.
4.  **Manajemen Kamar (CRUD):**
    * Menambahkan data kamar untuk kos tertentu (nama kamar, harga, ukuran).
    * Mengedit data kamar.
    * Mengupdate status ketersediaan kamar (*tersedia*, *penuh*).
    * Menghubungkan fasilitas khusus ke kamar.
5.  **Manajemen Foto:** Mengunggah dan mengelola foto-foto untuk setiap kamar.
6.  **Manajemen Booking:**
    * Melihat daftar booking yang masuk untuk kos miliknya.
    * Mengkonfirmasi booking (jika pembayaran sudah *paid*).
7.  **Ulasan:** Melihat ulasan dan rating yang diberikan oleh penyewa untuk kos miliknya.

---

## 5. Alur Pengguna (*User Flow*)

### A. Alur Pencari Kos
1.  **Pendaftaran:** Pengguna mengunjungi situs -> Klik "Daftar" -> Memilih "Pencari Kos" -> Mengisi formulir (nama, email, password, no_hp) -> Submit -> Akun dibuat dengan role = `pencari`.
2.  **Mencari Kos:** Pengguna login -> Masuk ke halaman utama -> Melihat daftar kos -> Menggunakan sidebar filter (misal: "Putri", "Harga < 500.000", "Fasilitas: AC") -> Daftar kos ter-filter.
3.  **Melihat Detail:** Pengguna mengklik satu kos -> Pindah ke halaman detail kos -> Melihat deskripsi, foto-foto, ulasan, dan daftar kamar yang tersedia.
4.  **Booking:** Pengguna memilih kamar -> Klik "Booking" -> Memilih tanggal `tgl_mulai_sewa` dan `tgl_selesai_sewa` -> Sistem menghitung `total_harga` -> Pengguna konfirmasi booking -> Data masuk ke tabel booking dengan `status_booking = 'pending'`.
5.  **Pembayaran:** Pengguna diarahkan ke halaman pembayaran -> Memilih metode -> (Simulasi) Transfer -> Data masuk ke tabel pembayaran dengan `status_pembayaran = 'paid'`. `status_booking` berubah menjadi `confirmed`.
6.  **Memberi Ulasan:** Setelah `tgl_selesai_sewa` berlalu dan `status_booking = 'completed'`, pengguna bisa masuk ke riwayat booking dan memberikan ulasan (rating & komentar) untuk `kos_id` tersebut.

### B. Alur Pemilik Kos
1.  **Pendaftaran:** Pengguna mengunjungi situs -> Klik "Daftar" -> Memilih "Pemilik Kos" -> Mengisi formulir -> Akun dibuat dengan role = `pemilik`.
2.  **Menambah Kos:** Pemilik login -> Masuk ke dashboard -> Klik "Tambah Kos Baru" -> Mengisi formulir (nama, alamat, deskripsi, tipe) -> Menyimpan. Kos baru tersimpan di tabel kos dengan `pemilik_id` yang sesuai.
3.  **Menambah Kamar:** Pemilik memilih kos yang ingin dikelola -> Klik "Tambah Kamar" -> Mengisi formulir (nama kamar, harga, ukuran) -> Memilih fasilitas kamar (dari tabel fasilitas) -> Menyimpan. Data tersimpan di tabel kamar dan kamar_fasilitas.
4.  **Upload Foto:** Pemilik masuk ke detail kamar -> "Upload Foto" -> Memilih file -> Foto tersimpan di tabel foto_kamar.
5.  **Mengelola Ketersediaan:** Pemilik melihat kamar "Kamar A" sudah penuh -> Masuk ke dashboard -> Edit Kamar A -> Ubah `status_ketersediaan` dari `tersedia` menjadi `penuh`. Kamar ini tidak akan muncul lagi di pencarian publik.
6.  **Melihat Ulasan:** Pemilik masuk ke dashboard -> Klik menu "Ulasan" -> Melihat daftar ulasan dan rating rata-rata untuk semua kos miliknya.

---

## 6. Arsitektur Teknis & Rencana Implementasi API (Routes)

Karena ini adalah monolitik Laravel, kita akan menggunakan controller untuk melayani Blade views dan juga rute API internal (jika diperlukan oleh JavaScript).

### A. Model Laravel yang Diperlukan
Berdasarkan skema DB, model yang harus dibuat:
* **User** (Relasi: `hasMany` Kos, `hasMany` Booking, `hasMany` Ulasan)
* **Kos** (Relasi: `belongsTo` User, `hasMany` Kamar, `belongsToMany` Fasilitas (as FasilitasUmum), `hasMany` Ulasan)
* **Kamar** (Relasi: `belongsTo` Kos, `hasMany` FotoKamar, `belongsToMany` Fasilitas (as FasilitasKamar), `hasMany` Booking)
* **Fasilitas** (Relasi: `belongsToMany` Kos, `belongsToMany` Kamar)
* **FotoKamar** (Relasi: `belongsTo` Kamar)
* **Booking** (Relasi: `belongsTo` User, `belongsTo` Kamar, `hasOne` Pembayaran, `hasOne` Ulasan)
* **Pembayaran** (Relasi: `belongsTo` Booking)
* **Ulasan** (Relasi: `belongsTo` Kos, `belongsTo` User, `belongsTo` Booking)

### B. Struktur Controller Utama
1.  **Auth (`AuthController`):** Menangani register dan login untuk kedua role.
2.  **Pencari:**
    * `KosPublicController`: Menangani logika untuk menampilkan daftar kos, filtering, dan halaman detail.
    * `PencariDashboardController`: Menampilkan riwayat booking pengguna.
3.  **Pemilik:**
    * `PemilikDashboardController`: Halaman utama dashboard pemilik.
    * `KosController`: Resource controller (CRUD) untuk Kos.
    * `KamarController`: Resource controller (CRUD) untuk Kamar (termasuk update status).
    * `FotoKamarController`: Menangani upload dan hapus foto.
4.  **Transaksi:**
    * `BookingController`: Menangani proses pembuatan booking.
    * `PembayaranController`: Menangani konfirmasi pembayaran.
    * `UlasanController`: Menangani pembuatan ulasan baru.

### C. Struktur Rute (`routes/web.php`)

Berikut adalah gambaran umum rute yang akan diimplementasikan:

```php
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KosPublicController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Pemilik\PemilikDashboardController;
use App\Http\Controllers\Pemilik\KosController;
use App\Http\Controllers\Pemilik\KamarController;
use App\Http\Controllers\Pemilik\FotoKamarController;

// --- Halaman Publik & Autentikasi ---
Route::get('/', [KosPublicController::class, 'index'])->name('home');
Route::get('/kos', [KosPublicController::class, 'search'])->name('kos.search');
Route::get('/kos/{kos_id}', [KosPublicController::class, 'show'])->name('kos.show');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Grup Rute untuk Pengguna Terautentikasi ---
Route::middleware(['auth'])->group(function () {

    // 1. Rute untuk Pencari Kos (Role: 'pencari')
    Route::middleware(['role:pencari'])->prefix('pencari')->name('pencari.')->group(function () {
        Route::get('/dashboard', [PencariDashboardController::class, 'index'])->name('dashboard');
        
        // Proses Booking
        Route::get('/booking/{kamar_id}', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        
        // Pembayaran
        Route::get('/booking/{booking_id}/bayar', [PembayaranController::class, 'create'])->name('pembayaran.create');
        Route::post('/booking/{booking_id}/bayar', [PembayaranController::class, 'store'])->name('pembayaran.store');
        
        // Ulasan
        Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    });

    // 2. Rute untuk Pemilik Kos (Role: 'pemilik')
    Route::middleware(['role:pemilik'])->prefix('pemilik')->name('pemilik.')->group(function () {
        Route::get('/dashboard', [PemilikDashboardController::class, 'index'])->name('dashboard');
        
        // Resource CRUD untuk Kos dan Kamar
        Route::resource('kos', KosController::class);
        // Nested resource untuk kamar agar URL menjadi /kos/{kos}/kamar/{kamar}
        Route::resource('kos.kamar', KamarController::class)->shallow(); 

        // Rute tambahan untuk update status ketersediaan kamar secara spesifik
        Route::patch('/kamar/{kamar_id}/status', [KamarController::class, 'updateStatus'])->name('kamar.updateStatus');
        
        // Rute untuk manajemen foto kamar
        Route::post('/kamar/{kamar_id}/foto', [FotoKamarController::class, 'store'])->name('foto.store');
        Route::delete('/foto/{foto_id}', [FotoKamarController::class, 'destroy'])->name('foto.destroy');
    });

});
