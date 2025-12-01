<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembayaranController extends Controller
{
    // Payment methods available
    protected $paymentMethods = [
        'bca' => 'BCA Transfer',
        'mandiri' => 'Mandiri Transfer',
        'bni' => 'BNI Transfer',
        'pulsa' => 'Pulsa/E-wallet',
        'cash' => 'Tunai'
    ];

    /**
     * Show payment form
     */
    public function create($booking_id)
    {
        $booking = Booking::with('kamar.kos', 'pencari', 'pembayaran')
            ->findOrFail($booking_id);

        // Check ownership
        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        // Check if already paid
        if ($booking->status_booking === 'confirmed' && $booking->pembayaran) {
            return redirect()->route('pencari.dashboard')
                ->with('info', 'Booking ini sudah dibayar.');
        }

        return view('pencari.pembayaran.create', [
            'booking' => $booking,
            'paymentMethods' => $this->paymentMethods
        ]);
    }

    /**
     * Process payment
     */
    public function store(Request $request, $booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Check ownership
        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'metode_pembayaran' => 'required|in:bca,mandiri,bni,pulsa,cash',
            'jumlah' => 'required|numeric|min:' . $booking->total_harga,
        ]);

        // Check if already paid
        if ($booking->pembayaran && $booking->pembayaran->status_pembayaran === 'paid') {
            return redirect()->back()->with('error', 'Booking ini sudah dibayar.');
        }

        // Ensure jumlah is positive
        $jumlah = floatval($data['jumlah']);
        if ($jumlah <= 0) {
            return redirect()->back()->with('error', 'Jumlah pembayaran harus lebih besar dari 0.');
        }

        // Create or update payment record
        $pembayaran = Pembayaran::updateOrCreate(
            ['booking_id' => $booking->booking_id],
            [
                'jumlah' => $jumlah,
                'metode_pembayaran' => $this->paymentMethods[$data['metode_pembayaran']] ?? $data['metode_pembayaran'],
                'status_pembayaran' => 'paid',
                'tgl_pembayaran' => now(),
            ]
        );

        // Update booking status to confirmed
        $booking->update(['status_booking' => 'confirmed']);

        return redirect()->route('pencari.pembayaran.confirmation', $booking->booking_id)
            ->with('success', 'Pembayaran berhasil!');
    }

    /**
     * Show payment confirmation
     */
    public function confirmation($booking_id)
    {
        $booking = Booking::with('pembayaran', 'kamar.kos', 'pencari')
            ->findOrFail($booking_id);

        if ($booking->pencari_id !== Auth::id()) {
            abort(403);
        }

        return view('pencari.pembayaran.confirmation', compact('booking'));
    }

    /**
     * List all payments (for pemilik - optional admin feature)
     */
    public function index()
    {
        // This could be used for admin/owner to see all payments
        // For now, restricted to superadmin
        if (Auth::user()->role !== 'pemilik') {
            abort(403);
        }

        $pembayaran = Pembayaran::with('booking.kamar.kos', 'booking.pencari')
            ->orderBy('tgl_pembayaran', 'desc')
            ->paginate(20);

        return view('pembayaran.index', compact('pembayaran'));
    }
}
