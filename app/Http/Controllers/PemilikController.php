<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\Ulasan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemilikController extends Controller
{
    /**
     * Show pemilik dashboard with stats
     */
    public function dashboard()
    {
        // Check if user is pemilik
        if (Auth::user()->role !== 'pemilik') {
            abort(403, 'Hanya pemilik yang bisa akses halaman ini');
        }

        $pemilikId = Auth::id();

        // Get all kos for this owner
        $kosCount = Kos::where('pemilik_id', $pemilikId)->count();

        // Get all rooms
        $totalKamar = \App\Models\Kamar::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->count();

        $availableKamar = \App\Models\Kamar::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status_ketersediaan', 'tersedia')->count();

        // Get bookings for all kos
        $bookingCount = Booking::whereHas('kamar.kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->count();

        $pendingBookings = Booking::whereHas('kamar.kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status_booking', 'pending')->count();

        $confirmedBookings = Booking::whereHas('kamar.kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status_booking', 'confirmed')->count();

        // Revenue calculation
        $totalRevenue = \App\Models\Pembayaran::whereHas('booking.kamar.kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->where('status_pembayaran', 'paid')->sum('jumlah');

        // Reviews stats
        $avgRating = Ulasan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->avg('rating') ?? 0;

        $totalReviews = Ulasan::whereHas('kos', function ($query) use ($pemilikId) {
            $query->where('pemilik_id', $pemilikId);
        })->count();

        // Recent bookings
        $recentBookings = Booking::with(['kamar.kos', 'pencari', 'pembayaran'])
            ->whereHas('kamar.kos', function ($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Recent reviews
        $recentReviews = Ulasan::with(['kos', 'pencari'])
            ->whereHas('kos', function ($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('tgl_ulasan', 'desc')
            ->limit(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'kosCount',
            'totalKamar',
            'availableKamar',
            'bookingCount',
            'pendingBookings',
            'confirmedBookings',
            'totalRevenue',
            'avgRating',
            'totalReviews',
            'recentBookings',
            'recentReviews'
        ));
    }
}
