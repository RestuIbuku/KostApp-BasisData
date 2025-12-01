@extends('layouts.app')

@section('title', 'Kelola Booking - Kost App')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <h3>Manajemen Booking</h3>
        </div>
    </div>

    <div class="glass-card">
        @if($bookings->isEmpty())
            <p class="text-muted">Belum ada booking.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Penyewa</th>
                            <th>Kamar</th>
                            <th>Tanggal Sewa</th>
                            <th>Total</th>
                            <th>Status Booking</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->pencari->nama_lengkap }}</td>
                                <td>{{ $booking->kamar->nama_kamar }} ({{ $booking->kamar->kos->nama_kos }})</td>
                                <td>{{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_booking == 'pending' ? 'warning' : ($booking->status_booking == 'confirmed' ? 'success' : 'danger') }}">
                                        {{ ucfirst($booking->status_booking) }}
                                    </span>
                                </td>
                                <td>
                                    @if($booking->pembayaran)
                                        <span class="badge bg-success">{{ $booking->pembayaran->metode_pembayaran }}</span>
                                    @else
                                        <span class="badge bg-secondary">Belum Bayar</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('pemilik.bookings.show', $booking->booking_id) }}" class="btn btn-sm btn-primary">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $bookings->links() }}</div>
        @endif
    </div>
</div>
@endsection
