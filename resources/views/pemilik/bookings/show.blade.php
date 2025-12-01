@extends('layouts.app')

@section('title', 'Detail Booking - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card">
                <h3 class="mb-4">Detail Booking #{{ $booking->booking_id }}</h3>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Penyewa</h5>
                        <p><strong>Nama:</strong> {{ $booking->pencari->nama_lengkap }}</p>
                        <p><strong>Email:</strong> {{ $booking->pencari->email }}</p>
                        <p><strong>No. HP:</strong> {{ $booking->pencari->no_hp }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Informasi Kamar</h5>
                        <p><strong>Kamar:</strong> {{ $booking->kamar->nama_kamar }}</p>
                        <p><strong>Kos:</strong> {{ $booking->kamar->kos->nama_kos }}</p>
                        <p><strong>Alamat:</strong> {{ $booking->kamar->kos->alamat }}</p>
                        <p><strong>Harga per Malam:</strong> Rp {{ number_format($booking->kamar->harga_per_malam, 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Periode Sewa</h5>
                        <p><strong>Mulai Sewa:</strong> {{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y H:i') }}</p>
                        <p><strong>Selesai Sewa:</strong> {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y H:i') }}</p>
                        <p><strong>Durasi:</strong> {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->diffInDays(\Carbon\Carbon::parse($booking->tgl_mulai_sewa)) + 1 }} malam</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan Pembayaran</h5>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                        @if($booking->pembayaran)
                            <p><strong>Status Pembayaran:</strong> <span class="badge bg-success">{{ ucfirst($booking->pembayaran->status_pembayaran) }}</span></p>
                            <p><strong>Metode Pembayaran:</strong> {{ $booking->pembayaran->metode_pembayaran }}</p>
                            <p><strong>Jumlah Dibayar:</strong> Rp {{ number_format($booking->pembayaran->jumlah, 0, ',', '.') }}</p>
                            <p><strong>Tanggal Bayar:</strong> {{ \Carbon\Carbon::parse($booking->pembayaran->tgl_pembayaran)->format('d M Y H:i') }}</p>
                        @else
                            <p><span class="badge bg-danger">Belum ada pembayaran</span></p>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Status Booking</h5>
                        <p><strong>Status:</strong> <span class="badge bg-{{ $booking->status_booking == 'pending' ? 'warning' : ($booking->status_booking == 'confirmed' ? 'success' : 'danger') }}">{{ ucfirst($booking->status_booking) }}</span></p>

                        @if($booking->status_booking == 'pending' && $booking->pembayaran && $booking->pembayaran->status_pembayaran == 'paid')
                            <form method="POST" action="{{ route('pemilik.bookings.confirm', $booking->booking_id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-success">Konfirmasi Booking</button>
                            </form>
                        @endif

                        @if($booking->status_booking != 'cancelled' && $booking->status_booking != 'completed')
                            <form method="POST" action="{{ route('pemilik.bookings.reject', $booking->booking_id) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-danger" onclick="return confirm('Tolak booking ini?')">Tolak Booking</button>
                            </form>
                        @endif
                    </div>
                </div>

                @if($booking->ulasan)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Ulasan Penyewa</h5>
                            <p class="mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $booking->ulasan->rating ? '#ffc107' : '#ccc' }};"></i>
                                @endfor
                                <strong class="ms-2">{{ $booking->ulasan->rating }}/5</strong>
                            </p>
                            <p>{{ $booking->ulasan->komentar }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($booking->ulasan->tgl_ulasan)->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                @endif

                <a href="{{ route('pemilik.bookings.index') }}" class="btn btn-outline-custom">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection
