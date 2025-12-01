@extends('layouts.app')

@section('title', 'Dashboard Pemilik - Kost App')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Dashboard Pemilik Kos</h1>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="glass-card text-center">
                <i class="fas fa-home text-primary mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted">Total Kos</h6>
                <h2 class="text-primary">{{ $kosCount }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <i class="fas fa-door-open text-success mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted">Kamar Tersedia</h6>
                <h2 class="text-success">{{ $availableKamar }}/{{ $totalKamar }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <i class="fas fa-calendar-check text-warning mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted">Total Booking</h6>
                <h2 class="text-warning">{{ $bookingCount }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="glass-card text-center">
                <i class="fas fa-star text-info mb-2" style="font-size: 2rem;"></i>
                <h6 class="text-muted">Rating Rata-rata</h6>
                <h2 class="text-info">{{ number_format($avgRating, 1) }}/5</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Revenue & Booking Stats -->
        <div class="col-lg-8 mb-4">
            <div class="glass-card">
                <h4 class="mb-4">Manajemen Booking</h4>
                <div class="row text-center mb-4">
                    <div class="col-md-4">
                        <div class="p-3 border-bottom border-warning">
                            <h5 class="text-warning">{{ $pendingBookings }}</h5>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border-bottom border-success">
                            <h5 class="text-success">{{ $confirmedBookings }}</h5>
                            <small class="text-muted">Dikonfirmasi</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 border-bottom border-primary">
                            <h5 class="text-primary">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h5>
                            <small class="text-muted">Total Revenue</small>
                        </div>
                    </div>
                </div>

                <a href="{{ route('pemilik.bookings.index') }}" class="btn btn-primary-gradient w-100">
                    <i class="fas fa-calendar-check me-2"></i> Kelola Booking
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="col-lg-4 mb-4">
            <div class="glass-card">
                <h4 class="mb-3">Menu Cepat</h4>
                <div class="d-grid gap-2">
                    <a href="{{ route('pemilik.kos.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-building me-2"></i> Kelola Kos
                    </a>
                    <a href="{{ route('pemilik.reviews.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-comments me-2"></i> Lihat Ulasan ({{ $totalReviews }})
                    </a>
                    <a href="{{ route('pemilik.pembayaran.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-credit-card me-2"></i> Pembayaran
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="glass-card mb-4">
        <h4 class="mb-3">Booking Terbaru</h4>
        @if($recentBookings->isEmpty())
            <p class="text-muted">Belum ada booking.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Penyewa</th>
                            <th>Kamar</th>
                            <th>Tanggal Booking</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>{{ $booking->pencari->nama_lengkap }}</td>
                                <td>{{ $booking->kamar->nama_kamar }} ({{ $booking->kamar->kos->nama_kos }})</td>
                                <td>{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}</td>
                                <td>Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_booking == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($booking->status_booking) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <!-- Recent Reviews -->
    <div class="glass-card">
        <h4 class="mb-3">Ulasan Terbaru</h4>
        @if($recentReviews->isEmpty())
            <p class="text-muted">Belum ada ulasan.</p>
        @else
            @foreach($recentReviews as $review)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1">
                                <strong>{{ $review->pencari->nama_lengkap }}</strong> untuk
                                <strong>{{ $review->kos->nama_kos }}</strong>
                            </p>
                            <p class="mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }};"></i>
                                @endfor
                                <span class="ms-2">{{ $review->rating }}/5</span>
                            </p>
                            <p class="mb-0 text-muted">{{ Str::limit($review->komentar, 100) }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($review->tgl_ulasan)->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
