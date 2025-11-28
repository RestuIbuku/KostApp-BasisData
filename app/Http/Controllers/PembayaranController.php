<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    public function create($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);
        return view('pembayaran.create', compact('booking'));
    }

    public function store(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        $data = $request->validate([
            'jumlah' => 'required|numeric|min:0',
            'metode_pembayaran' => 'required|string|max:50'
        ]);

        $pembayaran = Pembayaran::create([
            'booking_id' => $booking->booking_id,
            'jumlah' => $data['jumlah'],
            'metode_pembayaran' => $data['metode_pembayaran'],
            'status_pembayaran' => 'paid',
            'tgl_pembayaran' => now(),
        ]);

        // update booking status
        $booking->status_booking = 'confirmed';
        $booking->save();

        return redirect()->route('pencari.index')->with('success', 'Pembayaran berhasil, booking dikonfirmasi');
    }
}
