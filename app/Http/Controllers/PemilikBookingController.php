<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;

class PemilikBookingController extends Controller
{
    /**
     * Show all bookings for pemilik's kos
     */
    public function index()
    {
        $pemilikId = Auth::id();

        $bookings = Booking::with(['kamar.kos', 'pencari', 'pembayaran'])
            ->whereHas('kamar.kos', function ($query) use ($pemilikId) {
                $query->where('pemilik_id', $pemilikId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('pemilik.bookings.index', compact('bookings'));
    }

    /**
     * Show single booking details
     */
    public function show($booking_id)
    {
        $pemilikId = Auth::id();

        $booking = Booking::with(['kamar.kos', 'pencari', 'pembayaran', 'ulasan'])
            ->findOrFail($booking_id);

        // Check if this booking belongs to pemilik's kos
        if ($booking->kamar->kos->pemilik_id !== $pemilikId) {
            abort(403);
        }

        return view('pemilik.bookings.show', compact('booking'));
    }

    /**
     * Confirm booking (after payment is verified)
     */
    public function confirm($booking_id)
    {
        $pemilikId = Auth::id();

        $booking = Booking::findOrFail($booking_id);

        // Check if this booking belongs to pemilik's kos
        if ($booking->kamar->kos->pemilik_id !== $pemilikId) {
            abort(403);
        }

        // Check if payment is done
        if (!$booking->pembayaran || $booking->pembayaran->status_pembayaran !== 'paid') {
            return redirect()->back()->with('error', 'Pembayaran belum diterima.');
        }

        // Update booking status
        $booking->update(['status_booking' => 'confirmed']);

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    /**
     * Reject booking
     */
    public function reject($booking_id)
    {
        $pemilikId = Auth::id();

        $booking = Booking::findOrFail($booking_id);

        // Check if this booking belongs to pemilik's kos
        if ($booking->kamar->kos->pemilik_id !== $pemilikId) {
            abort(403);
        }

        // Can only reject pending bookings
        if ($booking->status_booking !== 'pending' && $booking->status_booking !== 'confirmed') {
            return redirect()->back()->with('error', 'Hanya booking pending/confirmed yang bisa ditolak.');
        }

        $booking->update(['status_booking' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking berhasil ditolak/dibatalkan.');
    }
}
