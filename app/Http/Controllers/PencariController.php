<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PencariController extends Controller
{
    /**
     * Menampilkan halaman daftar kost (Katalog) dengan filter
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'pencari') {
            abort(403, 'Hanya pencari yang bisa mengakses halaman ini');
        }

        $query = Kos::with('pemilik', 'kamar', 'fasilitasUmum');

        // Filter berdasarkan nama
        if ($request->filled('nama')) {
            $query->where('nama_kos', 'like', '%' . $request->nama . '%');
        }

        // Filter berdasarkan tipe kos
        if ($request->filled('tipe')) {
            $query->where('tipe_kos', $request->tipe);
        }

        // Filter berdasarkan range harga
        if ($request->filled('min_harga')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('harga_per_malam', '>=', $request->min_harga);
            });
        }

        if ($request->filled('max_harga')) {
            $query->whereHas('kamar', function ($q) use ($request) {
                $q->where('harga_per_malam', '<=', $request->max_harga);
            });
        }

        // Filter berdasarkan ketersediaan
        if ($request->filled('ketersediaan')) {
            if ($request->ketersediaan == 'tersedia') {
                $query->where('jumlah_kamar_kosong', '>', 0);
            }
        }

        $kosts = $query->latest()->paginate(12);

        return view('pencari.index', compact('kosts'));
    }

    /**
     * Menampilkan detail satu kost spesifik
     */
    public function show($id)
    {
        if (Auth::user()->role !== 'pencari') {
            abort(403, 'Hanya pencari yang bisa mengakses halaman ini');
        }

        $kost = Kos::with(['pemilik', 'kamar.fotoKamar', 'kamar.fasilitas', 'ulasan.pencari', 'fasilitasUmum'])
                   ->where('kos_id', $id)
                   ->firstOrFail();

        // Ambil daftar kamar dengan fasilitas dan foto
        $kamarList = $kost->kamar()->with(['fotoKamar', 'fasilitas'])->where('status_ketersediaan', 'tersedia')->get();

        // Calculate average rating
        $avgRating = $kost->ulasan()->avg('rating') ?? 0;
        $totalReviews = $kost->ulasan()->count();

        // Format nomor HP untuk WhatsApp
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

        return view('pencari.show', compact('kost', 'kamarList', 'formattedPhone', 'avgRating', 'totalReviews'));
    }

    /**
     * Dashboard untuk pencari: riwayat booking dan ulasan
     */
    public function dashboard()
    {
        if (Auth::user()->role !== 'pencari') {
            abort(403, 'Hanya pencari yang bisa mengakses halaman ini');
        }

        $userId = Auth::id();

        if (!$userId) {
            return redirect()->route('login');
        }

        // Get all bookings with details
        $bookings = Booking::with(['kamar.kos', 'pembayaran', 'ulasan'])
            ->where('pencari_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's reviews
        $ulasan = Ulasan::with('kos', 'booking')
            ->where('pencari_id', $userId)
            ->orderBy('tgl_ulasan', 'desc')
            ->get();

        // Stats
        $totalBookings = Booking::where('pencari_id', $userId)->count();
        $confirmedBookings = Booking::where('pencari_id', $userId)->where('status_booking', 'confirmed')->count();
        $completedBookings = Booking::where('pencari_id', $userId)->where('status_booking', 'completed')->count();
        $totalReviews = $ulasan->count();

        return view('pencari.dashboard', compact('bookings', 'ulasan', 'totalBookings', 'confirmedBookings', 'completedBookings', 'totalReviews'));
    }

    /**
     * Search and filter kos
     */
    public function search(Request $request)
    {
        return $this->index($request);
    }
}
