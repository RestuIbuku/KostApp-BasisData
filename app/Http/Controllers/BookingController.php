<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($kamar_id)
    {
        $kamar = Kamar::findOrFail($kamar_id);
        return view('booking.create', compact('kamar'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kamar_id' => 'required|exists:kamar,kamar_id',
            'tgl_mulai_sewa' => 'required|date',
            'tgl_selesai_sewa' => 'required|date|after_or_equal:tgl_mulai_sewa',
        ]);

        $kamar = Kamar::findOrFail($data['kamar_id']);
        $days = (strtotime($data['tgl_selesai_sewa']) - strtotime($data['tgl_mulai_sewa'])) / 86400 + 1;
        $total = $days * $kamar->harga_per_malam;

        $booking = Booking::create([
            'pencari_id' => Auth::id(),
            'kamar_id' => $data['kamar_id'],
            'tgl_mulai_sewa' => $data['tgl_mulai_sewa'],
            'tgl_selesai_sewa' => $data['tgl_selesai_sewa'],
            'total_harga' => $total,
            'status_booking' => 'pending',
            'created_at' => now(),
        ]);

        return redirect()->route('pembayaran.create', $booking->booking_id)->with('success', 'Booking dibuat. Lanjutkan ke pembayaran.');
    }
}
