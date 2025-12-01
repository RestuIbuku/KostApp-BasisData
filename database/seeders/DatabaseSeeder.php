<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kos;
use App\Models\Fasilitas;
use App\Models\Kamar;
use App\Models\FotoKamar;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\Ulasan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create or update users: pemilik and pencari
        $pemilik = User::updateOrCreate([
            'email' => 'pemilik1@gmail.com'
        ],[
            'nama_lengkap' => 'Pemilik Demo',
            'password_hash' => Hash::make('password'),
            'no_hp' => '081234567890',
            'role' => 'pemilik',
            'created_at' => now(),
        ]);

        $pencari = User::updateOrCreate([
            'email' => 'pencari1@gmail.com'
        ],[
            'nama_lengkap' => 'Pencari Demo',
            'password_hash' => Hash::make('password'),
            'no_hp' => '089876543210',
            'role' => 'pencari',
            'created_at' => now(),
        ]);

        // Create a kos
        $kos = Kos::create([
            'pemilik_id' => $pemilik->user_id,
            'nama_kos' => 'Kost Demo Sejahtera',
            'alamat' => 'Jl. Contoh No.1, Magetan',
            'deskripsi' => 'Kost nyaman, dekat kampus, tersedia WiFi dan air panas.',
            'tipe_kos' => 'campur',
            'latitude' => -11.00000000,
            'longitude' => 111.00000000,
            'foto' => 'kost-images/demo-cover.jpg',
            'jumlah_kamar_total' => 6,
            'jumlah_kamar_kosong' => 4,
            'created_at' => now(),
        ]);

        // Create fasilitas (umum & kamar)
        $f1 = Fasilitas::updateOrCreate(['nama_fasilitas' => 'WiFi'], ['tipe' => 'umum']);
        $f2 = Fasilitas::updateOrCreate(['nama_fasilitas' => 'Air Panas'], ['tipe' => 'umum']);
        $f3 = Fasilitas::updateOrCreate(['nama_fasilitas' => 'AC'], ['tipe' => 'kamar']);
        $f4 = Fasilitas::updateOrCreate(['nama_fasilitas' => 'Kasur'], ['tipe' => 'kamar']);

        // Attach fasilitas ke kos
        // attach only if not already attached
        $kos->fasilitasUmum()->syncWithoutDetaching([$f1->fasilitas_id, $f2->fasilitas_id]);

        // Create kamar untuk kos
        $kamar1 = Kamar::updateOrCreate([
            'kos_id' => $kos->kos_id,
            'nama_kamar' => 'Kamar A',
        ],[
            'kos_id' => $kos->kos_id,
            'harga_per_malam' => 80000,
            'status_ketersediaan' => 'tersedia',
            'ukuran_kamar' => '3x4 m',
        ]);
        $kamar2 = Kamar::updateOrCreate([
            'kos_id' => $kos->kos_id,
            'nama_kamar' => 'Kamar B',
        ],[
            'kos_id' => $kos->kos_id,
            'harga_per_malam' => 100000,
            'status_ketersediaan' => 'tersedia',
            'ukuran_kamar' => '3x5 m',
        ]);

        // Attach fasilitas ke kamar
        $kamar1->fasilitas()->syncWithoutDetaching([$f3->fasilitas_id, $f4->fasilitas_id]);
        $kamar2->fasilitas()->syncWithoutDetaching([$f4->fasilitas_id]);

        // Add photo entries for kamar
        FotoKamar::updateOrCreate(['kamar_id' => $kamar1->kamar_id, 'url_foto' => 'kamar-images/kamar-a-1.jpg'], ['deskripsi_foto' => 'Sudut kamar A']);
        FotoKamar::updateOrCreate(['kamar_id' => $kamar2->kamar_id, 'url_foto' => 'kamar-images/kamar-b-1.jpg'], ['deskripsi_foto' => 'Sudut kamar B']);

        // Create a booking by pencari
        $booking = Booking::updateOrCreate([
            'pencari_id' => $pencari->user_id,
            'kamar_id' => $kamar1->kamar_id,
            'tgl_mulai_sewa' => now()->addDays(2)->toDateString(),
        ],[
            'pencari_id' => $pencari->user_id,
            'kamar_id' => $kamar1->kamar_id,
            'tgl_selesai_sewa' => now()->addDays(4)->toDateString(),
            'total_harga' => 3 * $kamar1->harga_per_malam,
            'status_booking' => 'pending',
            'created_at' => now(),
        ]);

        // Create pembayaran (simulate paid)
        Pembayaran::updateOrCreate(['booking_id' => $booking->booking_id], [
            'jumlah' => $booking->total_harga,
            'metode_pembayaran' => 'BCA',
            'status_pembayaran' => 'paid',
            'tgl_pembayaran' => now(),
        ]);

        // Create ulasan (optional sample, link to booking)
        Ulasan::updateOrCreate(['booking_id' => $booking->booking_id], [
            'kos_id' => $kos->kos_id,
            'pencari_id' => $pencari->user_id,
            'rating' => 5,
            'komentar' => 'Kost nyaman dan bersih.',
            'tgl_ulasan' => now(),
        ]);
    }
}
