@extends('layouts.app')

@section('title', 'Dashboard Pencari - Kost App')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Dashboard Pencari Kos</h1>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="glass-card text-center">
                <h6 class="text-muted">Total Booking</h6>
                <h2 class="text-primary">{{ $totalBookings }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <h6 class="text-muted">Dikonfirmasi</h6>
                <h2 class="text-success">{{ $confirmedBookings }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <h6 class="text-muted">Selesai</h6>
                <h2 class="text-info">{{ $completedBookings }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <h6 class="text-muted">Ulasan Saya</h6>
                <h2 class="text-warning">{{ $totalReviews }}</h2>
            </div>
        </div>
    </div>

    <!-- Riwayat Booking -->
    <div class="glass-card mb-4">
        <h3 class="mb-3">Riwayat Booking Saya</h3>
        @if ($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Kamar</th>
                            <th>Kos</th>
                            <th>Tanggal Sewa</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <td><strong>{{ $booking->kamar->nama_kamar }}</strong></td>
                                <td>{{ $booking->kamar->kos->nama_kos }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_booking == 'pending' ? 'warning' : ($booking->status_booking == 'confirmed' ? 'success' : ($booking->status_booking == 'completed' ? 'info' : 'danger')) }}">
                                        {{ ucfirst($booking->status_booking) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($booking->status_booking == 'pending')
                                        <a href="{{ route('pencari.pembayaran.create', $booking->booking_id) }}" class="btn btn-sm btn-primary">Bayar</a>
                                    @elseif ($booking->status_booking == 'confirmed' && now() > \Carbon\Carbon::parse($booking->tgl_selesai_sewa) && !$booking->ulasan)
                                        <a href="{{ route('pencari.ulasan.create', $booking->booking_id) }}" class="btn btn-sm btn-warning">Beri Ulasan</a>
                                    @elseif ($booking->status_booking == 'completed' && !$booking->ulasan)
                                        <a href="{{ route('pencari.ulasan.create', $booking->booking_id) }}" class="btn btn-sm btn-warning">Beri Ulasan</a>
                                    @elseif ($booking->ulasan)
                                        <span class="badge bg-secondary">Sudah Diulas</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $bookings->links() }}</div>
        @else
            <p class="text-muted">Anda belum memiliki booking.</p>
        @endif
    </div>

    <!-- Ulasan Saya -->
    <div class="glass-card">
        <h3 class="mb-3">Ulasan Saya</h3>
        @if ($ulasan->count() > 0)
            @foreach ($ulasan as $u)
                <div class="card mb-3 border-left border-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title mb-1">{{ $u->kos->nama_kos }}</h5>
                                <p class="mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="color: {{ $i <= $u->rating ? '#ffc107' : '#ccc' }};"></i>
                                    @endfor
                                    <strong class="ms-2">{{ $u->rating }}/5</strong>
                                </p>
                                <p class="card-text">{{ $u->komentar }}</p>
                                <small class="text-muted">{{ \Carbon\Carbon::parse($u->tgl_ulasan)->diffForHumans() }}</small>
                            </div>
                            <form method="POST" action="{{ route('pencari.ulasan.destroy', $u->ulasan_id) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus ulasan ini?')">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-muted">Anda belum memberikan ulasan apapun.</p>
        @endif
    </div>
</div>

<!-- Modal Ulasan -->
@foreach ($bookings->where('status_booking', 'confirmed') as $booking)
    @if (now() > $booking->tgl_selesai_sewa && !$booking->ulasan)
        <div class="modal fade" id="ulasanModal{{ $booking->booking_id }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Beri Ulasan untuk {{ $booking->kamar->kos->nama_kos }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('pencari.ulasan.store') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="kos_id" value="{{ $booking->kamar->kos->kos_id }}">
                            <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">

                            <div class="mb-3">
                                <label for="rating{{ $booking->booking_id }}" class="form-label">Rating</label>
                                <select name="rating" id="rating{{ $booking->booking_id }}" class="form-select" required>
                                    <option value="">-- Pilih Rating --</option>
                                    <option value="1">1 - Sangat Buruk</option>
                                    <option value="2">2 - Buruk</option>
                                    <option value="3">3 - Cukup</option>
                                    <option value="4">4 - Bagus</option>
                                    <option value="5">5 - Sangat Bagus</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="komentar{{ $booking->booking_id }}" class="form-label">Komentar</label>
                                <textarea name="komentar" id="komentar{{ $booking->booking_id }}" class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
