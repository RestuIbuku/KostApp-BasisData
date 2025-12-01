<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UlasanController extends Controller
{
    /**
     * Show form to create review
     */
    public function create($booking_id)
    {
        $booking = Booking::with('kamar.kos', 'pencari')
            ->findOrFail($booking_id);

        // Check ownership
        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        // Check if booking is completed (checkout date has passed)
        $endDate = Carbon::parse($booking->tgl_selesai_sewa);
        if ($endDate->isFuture()) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi ulasan setelah checkout.');
        }

        // Check if review already exists
        $existingReview = Ulasan::where('booking_id', $booking_id)->first();
        if ($existingReview) {
            return redirect()->back()->with('info', 'Anda sudah memberikan ulasan untuk booking ini.');
        }

        return view('ulasan.create', compact('booking'));
    }

    /**
     * Store review
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'booking_id' => 'required|exists:booking,booking_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Get booking details
        $booking = Booking::findOrFail($data['booking_id']);

        // Check ownership
        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        // Check if booking is completed
        $endDate = Carbon::parse($booking->tgl_selesai_sewa);
        if ($endDate->isFuture()) {
            return redirect()->back()->with('error', 'Anda hanya bisa memberi ulasan setelah checkout.');
        }

        // Check if review already exists
        $existingReview = Ulasan::where('booking_id', $booking->booking_id)->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk booking ini.');
        }

        // Create review
        $ulasan = Ulasan::create([
            'kos_id' => $booking->kamar->kos_id,
            'pencari_id' => Auth::id(),
            'booking_id' => $booking->booking_id,
            'rating' => $data['rating'],
            'komentar' => $data['komentar'],
            'tgl_ulasan' => now(),
        ]);

        // Update booking status to completed
        $booking->update(['status_booking' => 'completed']);

        return redirect()->route('pencari.dashboard')
            ->with('success', 'Terima kasih atas ulasan Anda!');
    }

    /**
     * Show reviews for a kos
     */
    public function kosReviews($kos_id)
    {
        $kos = Kos::findOrFail($kos_id);

        $reviews = Ulasan::with('pencari', 'booking')
            ->where('kos_id', $kos_id)
            ->orderBy('tgl_ulasan', 'desc')
            ->paginate(10);

        $avgRating = Ulasan::where('kos_id', $kos_id)->avg('rating');
        $totalReviews = Ulasan::where('kos_id', $kos_id)->count();

        return view('ulasan.kos-reviews', compact('kos', 'reviews', 'avgRating', 'totalReviews'));
    }

    /**
     * Delete review (only by owner)
     */
    public function destroy($ulasan_id)
    {
        $ulasan = Ulasan::findOrFail($ulasan_id);

        // Check ownership
        if ($ulasan->pencari_id !== Auth::id()) {
            abort(403);
        }

        // Check if user is pemilik and this is their kos
        if (Auth::user()->role === 'pemilik') {
            $kos = Kos::findOrFail($ulasan->kos_id);
            if ($kos->pemilik_id !== Auth::id()) {
                abort(403);
            }
        }

        $ulasan->delete();

        return redirect()->back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
