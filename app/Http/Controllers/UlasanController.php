<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'kos_id' => 'required|exists:kos,kos_id',
            'booking_id' => 'nullable|exists:booking,booking_id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $data['pencari_id'] = Auth::id();
        $data['tgl_ulasan'] = now();

        $ulasan = Ulasan::create($data);

        if (!empty($data['booking_id'])) {
            $booking = Booking::find($data['booking_id']);
            if ($booking) {
                $booking->status_booking = 'completed';
                $booking->save();
            }
        }

        return back()->with('success', 'Terima kasih atas ulasan Anda');
    }
}
