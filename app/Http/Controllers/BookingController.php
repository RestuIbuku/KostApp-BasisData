<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kamar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Show booking form for a specific room
     */
    public function create($kamar_id)
    {
        $kamar = Kamar::with('kos', 'fotoKamar', 'fasilitas')->findOrFail($kamar_id);

        // Check if room is available
        if ($kamar->status_ketersediaan === 'penuh') {
            return redirect()->route('pencari.show', $kamar->kos->kos_id)
                ->with('error', 'Kamar ini sudah penuh dan tidak tersedia untuk booking.');
        }

        return view('pencari.booking.create', compact('kamar'));
    }

    /**
     * Check availability and calculate price via AJAX
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'kamar_id' => 'required|exists:kamar,kamar_id',
            'tgl_mulai_sewa' => 'required|date',
            'tgl_selesai_sewa' => 'required|date|after_or_equal:tgl_mulai_sewa',
        ]);

        $kamar = Kamar::findOrFail($request->kamar_id);

        // Check date conflict with existing bookings
        $conflict = Booking::where('kamar_id', $kamar->kamar_id)
            ->where('status_booking', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('tgl_mulai_sewa', [$request->tgl_mulai_sewa, $request->tgl_selesai_sewa])
                    ->orWhereBetween('tgl_selesai_sewa', [$request->tgl_mulai_sewa, $request->tgl_selesai_sewa])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('tgl_mulai_sewa', '<=', $request->tgl_mulai_sewa)
                            ->where('tgl_selesai_sewa', '>=', $request->tgl_selesai_sewa);
                    });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'available' => false,
                'message' => 'Kamar tidak tersedia pada tanggal yang dipilih.'
            ]);
        }

        // Calculate duration and price
        $start = Carbon::parse($request->tgl_mulai_sewa);
        $end = Carbon::parse($request->tgl_selesai_sewa);
        $days = $end->diffInDays($start) + 1;
        $total = $days * $kamar->harga_per_malam;

        return response()->json([
            'available' => true,
            'days' => $days,
            'harga_per_malam' => $kamar->harga_per_malam,
            'total_harga' => $total,
            'message' => "Total {$days} malam x Rp " . number_format($kamar->harga_per_malam, 0) . " = Rp " . number_format($total, 0)
        ]);
    }

    /**
     * Store booking
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kamar_id' => 'required|exists:kamar,kamar_id',
            'tgl_mulai_sewa' => 'required|date|after_or_equal:today',
            'tgl_selesai_sewa' => 'required|date|after_or_equal:tgl_mulai_sewa',
        ]);

        $kamar = Kamar::findOrFail($data['kamar_id']);

        // Verify room is still available
        if ($kamar->status_ketersediaan === 'penuh') {
            return redirect()->back()->with('error', 'Kamar ini sudah penuh.');
        }

        // Check date conflict again (security check)
        $conflict = Booking::where('kamar_id', $kamar->kamar_id)
            ->where('status_booking', '!=', 'cancelled')
            ->where(function ($query) use ($data) {
                $query->whereBetween('tgl_mulai_sewa', [$data['tgl_mulai_sewa'], $data['tgl_selesai_sewa']])
                    ->orWhereBetween('tgl_selesai_sewa', [$data['tgl_mulai_sewa'], $data['tgl_selesai_sewa']])
                    ->orWhere(function ($q) use ($data) {
                        $q->where('tgl_mulai_sewa', '<=', $data['tgl_mulai_sewa'])
                            ->where('tgl_selesai_sewa', '>=', $data['tgl_selesai_sewa']);
                    });
            })
            ->exists();

        if ($conflict) {
            return redirect()->back()->with('error', 'Tanggal yang dipilih sudah dipesan.');
        }

        // Calculate total price
        $start = Carbon::parse($data['tgl_mulai_sewa']);
        $end = Carbon::parse($data['tgl_selesai_sewa']);
        $days = $end->diffInDays($start) + 1;
        $total = $days * $kamar->harga_per_malam;

        // Create booking with pending status
        $booking = Booking::create([
            'pencari_id' => Auth::id(),
            'kamar_id' => $data['kamar_id'],
            'tgl_mulai_sewa' => $data['tgl_mulai_sewa'],
            'tgl_selesai_sewa' => $data['tgl_selesai_sewa'],
            'total_harga' => $total,
            'status_booking' => 'pending',
            'created_at' => now(),
        ]);

        return redirect()->route('pembayaran.create', $booking->booking_id)
            ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan ke pembayaran.');
    }

    /**
     * Show user's bookings
     */
    public function myBookings()
    {
        $bookings = Booking::with('kamar.kos', 'pembayaran', 'ulasan')
            ->where('pencari_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pencari.booking.my-bookings', compact('bookings'));
    }

    /**
     * Cancel booking (only if still pending)
     */
    public function cancel($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Check ownership
        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        // Only allow cancellation if pending
        if ($booking->status_booking !== 'pending') {
            return redirect()->back()->with('error', 'Hanya booking dengan status pending yang bisa dibatalkan.');
        }

        $booking->update(['status_booking' => 'cancelled']);

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
