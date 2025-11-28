# Skema Database Aplikasi Booking Kos UNESA Magetan

## Ringkasan 10 Tabel Utama

Database ini menggunakan 10 tabel utama untuk mengelola sistem booking kos dengan relasi antar tabel yang kompleks.

---

## 1. **users** - Tabel Pengguna
Menyimpan data pengguna yang terdaftar (baik Pencari Kos maupun Pemilik Kos).

| Field | Tipe | Keterangan |
|-------|------|-----------|
| user_id | BIGINT UNSIGNED (PK) | ID pengguna unik |
| nama_lengkap | VARCHAR(100) | Nama lengkap pengguna |
| email | VARCHAR(100) UNIQUE | Email unik |
| password_hash | VARCHAR(255) | Hash password |
| no_hp | VARCHAR(15) | Nomor telepon |
| role | ENUM('pencari','pemilik') | Role pengguna |
| created_at | TIMESTAMP | Waktu pendaftaran |

---

## 2. **kos** - Tabel Properti Kos
Menyimpan informasi utama setiap properti kos yang didaftarkan.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| kos_id | BIGINT UNSIGNED (PK) | ID kos unik |
| pemilik_id | BIGINT UNSIGNED (FK) | ID pemilik (referensi users.user_id) |
| nama_kos | VARCHAR(150) | Nama properti kos |
| alamat | TEXT | Alamat lengkap |
| deskripsi | TEXT | Deskripsi kos |
| tipe_kos | ENUM('putra','putri','campur') | Tipe kos |
| latitude | DECIMAL(10,8) | Koordinat latitude |
| longitude | DECIMAL(11,8) | Koordinat longitude |
| foto | VARCHAR(255) | Path foto cover kos |
| jumlah_kamar_total | INT | Total jumlah kamar |
| jumlah_kamar_kosong | INT | Jumlah kamar yang tersedia |
| created_at | TIMESTAMP | Waktu pembuatan data |

---

## 3. **fasilitas** - Tabel Fasilitas
Menyimpan daftar fasilitas yang dapat dihubungkan ke kos atau kamar.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| fasilitas_id | BIGINT UNSIGNED (PK) | ID fasilitas unik |
| nama_fasilitas | VARCHAR(100) UNIQUE | Nama fasilitas (misal: AC, WiFi, dll) |
| tipe | ENUM('kamar','umum') | Tipe fasilitas (untuk kamar atau fasilitas umum) |

**Contoh data:**
- WiFi (umum)
- Air Panas (umum)
- AC (kamar)
- Kasur (kamar)

---

## 4. **kamar** - Tabel Kamar
Menyimpan data setiap kamar dalam properti kos.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| kamar_id | BIGINT UNSIGNED (PK) | ID kamar unik |
| kos_id | BIGINT UNSIGNED (FK) | ID kos (referensi kos.kos_id) |
| nama_kamar | VARCHAR(100) | Nama/nomor kamar (misal: Kamar A, Kamar 101) |
| harga_per_malam | DECIMAL(12,2) | Harga per malam |
| status_ketersediaan | ENUM('tersedia','penuh') | Status ketersediaan kamar |
| ukuran_kamar | VARCHAR(50) | Ukuran kamar (misal: 3x4 m) |

---

## 5. **foto_kamar** - Tabel Foto Kamar
Menyimpan foto-foto untuk setiap kamar.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| foto_id | BIGINT UNSIGNED (PK) | ID foto unik |
| kamar_id | BIGINT UNSIGNED (FK) | ID kamar (referensi kamar.kamar_id) |
| url_foto | VARCHAR(255) | Path/URL foto |
| deskripsi_foto | VARCHAR(255) | Deskripsi foto |

---

## 6. **booking** - Tabel Booking
Menyimpan data booking yang dilakukan pencari kos.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| booking_id | BIGINT UNSIGNED (PK) | ID booking unik |
| pencari_id | BIGINT UNSIGNED (FK) | ID pencari/penyewa (referensi users.user_id) |
| kamar_id | BIGINT UNSIGNED (FK) | ID kamar (referensi kamar.kamar_id) |
| tgl_mulai_sewa | DATE | Tanggal mulai sewa |
| tgl_selesai_sewa | DATE | Tanggal selesai sewa |
| total_harga | DECIMAL(12,2) | Total harga sewa |
| status_booking | ENUM('pending','confirmed','completed','cancelled') | Status booking |
| created_at | TIMESTAMP | Waktu pembuatan booking |

---

## 7. **pembayaran** - Tabel Pembayaran
Menyimpan data pembayaran untuk setiap booking.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| pembayaran_id | BIGINT UNSIGNED (PK) | ID pembayaran unik |
| booking_id | BIGINT UNSIGNED (FK, UNIQUE) | ID booking (referensi booking.booking_id) |
| jumlah | DECIMAL(12,2) | Jumlah yang dibayarkan |
| metode_pembayaran | VARCHAR(50) | Metode pembayaran (BCA, MANDIRI, PULSA, dll) |
| status_pembayaran | ENUM('pending','paid','failed') | Status pembayaran |
| tgl_pembayaran | TIMESTAMP | Waktu pembayaran |

---

## 8. **ulasan** - Tabel Ulasan
Menyimpan ulasan dan rating yang diberikan pencari kos setelah booking selesai.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| ulasan_id | BIGINT UNSIGNED (PK) | ID ulasan unik |
| kos_id | BIGINT UNSIGNED (FK) | ID kos (referensi kos.kos_id) |
| pencari_id | BIGINT UNSIGNED (FK) | ID pencari (referensi users.user_id) |
| booking_id | BIGINT UNSIGNED (FK) | ID booking (referensi booking.booking_id) |
| rating | INT | Rating 1-5 |
| komentar | TEXT | Komentar ulasan |
| tgl_ulasan | TIMESTAMP | Waktu pemberian ulasan |

---

## 9. **kos_fasilitas** - Tabel Junction (Many-to-Many)
Menyimpan hubungan antara kos dan fasilitas umum.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| kos_id | BIGINT UNSIGNED (FK, PK) | ID kos |
| fasilitas_id | BIGINT UNSIGNED (FK, PK) | ID fasilitas |

**Primary Key:** (kos_id, fasilitas_id)

---

## 10. **kamar_fasilitas** - Tabel Junction (Many-to-Many)
Menyimpan hubungan antara kamar dan fasilitas kamar.

| Field | Tipe | Keterangan |
|-------|------|-----------|
| kamar_id | BIGINT UNSIGNED (FK, PK) | ID kamar |
| fasilitas_id | BIGINT UNSIGNED (FK, PK) | ID fasilitas |

**Primary Key:** (kamar_id, fasilitas_id)

---

## Relasi Antar Tabel

```
users (1) ─── (M) kos
users (1) ─── (M) booking
users (1) ─── (M) ulasan

kos (1) ───────────── (M) kamar
kos (1) ───────────── (M) ulasan
kos (M) ──────────── (M) fasilitas (via kos_fasilitas)

kamar (1) ─────────── (M) booking
kamar (1) ─────────── (M) foto_kamar
kamar (M) ──────────── (M) fasilitas (via kamar_fasilitas)

booking (1) ──────── (1) pembayaran
booking (1) ──────── (1) ulasan

fasilitas (M) ─────── (M) kos (via kos_fasilitas)
fasilitas (M) ─────── (M) kamar (via kamar_fasilitas)
```

---

## Konfigurasi Migration di Laravel

Semua migration files sudah dibuat dan dijalankan:

1. `0001_01_01_000000_create_users_table.php` - Users
2. `2025_11_06_084507_create_kos_table.php` - Kos
3. `2025_11_27_000001_create_fasilitas_table.php` - Fasilitas
4. `2025_11_27_000002_create_kamar_table.php` - Kamar
5. `2025_11_27_000003_create_foto_kamar_table.php` - Foto Kamar
6. `2025_11_27_000004_create_booking_table.php` - Booking
7. `2025_11_27_000005_create_pembayaran_table.php` - Pembayaran
8. `2025_11_27_000006_create_ulasan_table.php` - Ulasan
9. `2025_11_27_000007_create_kos_fasilitas_table.php` - Kos Fasilitas (Junction)
10. `2025_11_27_000008_create_kamar_fasilitas_table.php` - Kamar Fasilitas (Junction)

---

## Fitur Keamanan Database

✅ **Foreign Key Constraints:** Semua tabel memiliki foreign key untuk menjaga integritas referensial
✅ **Cascade Delete:** Data related otomatis terhapus ketika parent dihapus
✅ **Unique Constraints:** Email user dan nama fasilitas unik
✅ **Default Values:** Status booking, pembayaran, dan ketersediaan memiliki default value
✅ **Timestamps:** Mencatat waktu pembuatan data

---

## Status Implementation

✅ Database structure lengkap dengan 10 tabel
✅ Semua migrations berhasil dijalankan
✅ Foreign key relationships sudah dikonfigurasi
✅ Siap untuk development fitur aplikasi
