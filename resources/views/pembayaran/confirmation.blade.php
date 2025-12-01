@extends('layouts.app')

@section('title', 'Konfirmasi Pembayaran - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card text-center">
                <h2 class="mb-3">Pembayaran Berhasil</h2>
                <p class="mb-4">Terima kasih. Pembayaran untuk booking <strong>#{{ $booking->booking_id }}</strong> telah kami terima.</p>

                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Kamar:</strong> {{ $booking->kamar->nama_kamar }} ({{ $booking->kamar->kos->nama_kos }})</p>
                        <p><strong>Jumlah:</strong> Rp {{ number_format($booking->pembayaran->jumlah ?? $booking->total_harga,0,',','.') }}</p>
                        <p><strong>Metode:</strong> {{ $booking->pembayaran->metode_pembayaran ?? '-' }}</p>
                        <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($booking->pembayaran->tgl_pembayaran ?? now())->format('d M Y H:i') }}</p>
                        <p><strong>Status Booking:</strong> <span class="badge bg-success">{{ ucfirst($booking->status_booking) }}</span></p>
                    </div>
                </div>

                <a href="{{ route('pencari.dashboard') }}" class="btn btn-primary-gradient">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
