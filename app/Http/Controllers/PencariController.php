<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PencariController extends Controller
{
    /**
     * Menampilkan halaman daftar kost (Katalog)
     */
    public function index()
    {
        // Ambil data kost dari database
        // 'with('pemilik')' = Optimasi biar query ke database user cuma sekali
        // 'latest()' = Urutkan dari yang paling baru diinput
        $kosts = Kos::with('pemilik')->latest()->get();

        // Kirim data ke view 'pencari/index.blade.php'
        return view('pencari.index', compact('kosts'));
    }

    /**
     * Menampilkan detail satu kost spesifik
     */
    public function show($id)
    {
        // Cari kost berdasarkan 'kos_id' dengan eager load kamar dan foto
        // 'firstOrFail' artinya kalau id gak ketemu, otomatis tampilkan error 404 Not Found
        $kost = Kos::with(['pemilik', 'kamar.fotoKamar', 'ulasan.pencari', 'fasilitasUmum'])
                   ->where('kos_id', $id)
                   ->firstOrFail();

        // Ambil daftar kamar dengan fasilitas dan foto
        $kamarList = $kost->kamar()->with(['fotoKamar', 'fasilitas'])->get();

        // Format nomor HP untuk WhatsApp (pastikan dimulai dengan +62)
        $phone = $kost->pemilik->no_hp;
        if (strpos($phone, '+62') !== 0) {
            if (strpos($phone, '62') === 0) {
                $formattedPhone = '+' . $phone;
            } elseif (strpos($phone, '08') === 0) {
                $formattedPhone = '+62' . substr($phone, 1);
            } else {
                $formattedPhone = '+62' . $phone;
            }
        } else {
            $formattedPhone = $phone;
        }

        // Kirim data ke view 'pencari/show.blade.php'
        return view('pencari.show', compact('kost', 'kamarList', 'formattedPhone'));
    }

    /**
     * Dashboard untuk pencari: riwayat booking dan ulasan
     */
    public function dashboard()
    {
        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        $bookings = Booking::with(['kamar.kos', 'ulasan'])->where('pencari_id', $userId)->latest()->get();
        $ulasan = Ulasan::with('kos')->where('pencari_id', $userId)->latest()->get();

        return view('pencari.dashboard', compact('bookings', 'ulasan'));
    }
}
