<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\Request;

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
        // Cari kost berdasarkan 'kos_id'
        // 'firstOrFail' artinya kalau id gak ketemu, otomatis tampilkan error 404 Not Found
        $kost = Kos::with('pemilik')->where('kos_id', $id)->firstOrFail();

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
        return view('pencari.show', compact('kost', 'formattedPhone'));
    }
}