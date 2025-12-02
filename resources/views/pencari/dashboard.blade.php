@extends('layouts.app')

@section('title', 'Dashboard Pencari - Kost App')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h1 class="mb-1" style="font-size: 2.5rem; font-weight: 700;">Dashboard Pencari Kos</h1>
            <p class="text-muted">Kelola booking dan ulasan Anda dengan mudah</p>
        </div>
        <div>
            <a href="{{ route('pencari.index') }}" class="btn btn-primary-gradient">
                <i class="fas fa-search me-2"></i>Jelajahi Kos
            </a>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-5 g-3">
        <div class="col-md-6 col-lg-3">
            <div class="glass-card text-center stat-card">
                <div class="stat-icon primary mb-3">
                    <i class="fas fa-calendar-check fa-lg"></i>
                </div>
                <h6 class="text-muted small mb-2">Total Booking</h6>
                <h2 class="text-primary fw-bold">{{ $totalBookings }}</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="glass-card text-center stat-card">
                <div class="stat-icon success mb-3">
                    <i class="fas fa-check-circle fa-lg"></i>
                </div>
                <h6 class="text-muted small mb-2">Dikonfirmasi</h6>
                <h2 class="text-success fw-bold">{{ $confirmedBookings }}</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="glass-card text-center stat-card">
                <div class="stat-icon info mb-3">
                    <i class="fas fa-flag-checkered fa-lg"></i>
                </div>
                <h6 class="text-muted small mb-2">Selesai</h6>
                <h2 class="text-info fw-bold">{{ $completedBookings }}</h2>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="glass-card text-center stat-card">
                <div class="stat-icon warning mb-3">
                    <i class="fas fa-star fa-lg"></i>
                </div>
                <h6 class="text-muted small mb-2">Ulasan Saya</h6>
                <h2 class="text-warning fw-bold">{{ $totalReviews }}</h2>
            </div>
        </div>
    </div>

    <!-- Riwayat Booking -->
    <div class="glass-card mb-4">
        <h3 class="mb-3 fw-bold d-flex align-items-center">
            <i class="fas fa-history me-2 text-primary"></i>Riwayat Booking Saya
        </h3>
        @if ($bookings->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr style="border-bottom: 2px solid var(--primary-color);">
                            <th><i class="fas fa-door-open me-2"></i>Kamar</th>
                            <th><i class="fas fa-building me-2"></i>Kos</th>
                            <th><i class="fas fa-calendar me-2"></i>Tanggal Sewa</th>
                            <th><i class="fas fa-money-bill me-2"></i>Total Harga</th>
                            <th><i class="fas fa-tag me-2"></i>Status</th>
                            <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr class="booking-row" style="transition: all 0.3s;">
                                <td><strong>{{ $booking->kamar->nama_kamar }}</strong></td>
                                <td>{{ $booking->kamar->kos->nama_kos }}</td>
                                <td>
                                    <small>
                                        <i class="fas fa-arrow-right text-muted"></i>
                                        {{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y') }}
                                        <br>
                                        <i class="fas fa-arrow-left text-muted"></i>
                                        {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y') }}
                                    </small>
                                </td>
                                <td><strong class="text-primary">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></td>
                                <td>
                                    <span class="badge bg-{{ $booking->status_booking == 'pending' ? 'warning' : ($booking->status_booking == 'confirmed' ? 'success' : ($booking->status_booking == 'completed' ? 'info' : 'danger')) }} rounded-pill px-3 py-2">
                                        @if($booking->status_booking == 'pending')
                                            <i class="fas fa-hourglass-half me-1"></i>Pending
                                        @elseif($booking->status_booking == 'confirmed')
                                            <i class="fas fa-check me-1"></i>Dikonfirmasi
                                        @elseif($booking->status_booking == 'completed')
                                            <i class="fas fa-flag-checkered me-1"></i>Selesai
                                        @else
                                            <i class="fas fa-times me-1"></i>Ditolak
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if ($booking->status_booking == 'pending')
                                            <a href="{{ route('pencari.pembayaran.create', $booking->booking_id) }}" class="btn btn-sm btn-primary" title="Bayar sekarang">
                                                <i class="fas fa-credit-card me-1"></i>Bayar
                                            </a>
                                        @elseif ($booking->status_booking == 'completed' && !$booking->ulasan)
                                            <a href="{{ route('pencari.ulasan.create', $booking->booking_id) }}" class="btn btn-sm btn-warning" title="Beri ulasan">
                                                <i class="fas fa-star me-1"></i>Ulasan
                                            </a>
                                        @elseif ($booking->status_booking == 'confirmed' && \Carbon\Carbon::now() > \Carbon\Carbon::parse($booking->tgl_selesai_sewa) && !$booking->ulasan)
                                            <a href="{{ route('pencari.ulasan.create', $booking->booking_id) }}" class="btn btn-sm btn-warning" title="Beri ulasan">
                                                <i class="fas fa-star me-1"></i>Ulasan
                                            </a>
                                        @elseif ($booking->ulasan)
                                            <button class="btn btn-sm btn-secondary" disabled title="Sudah diberi ulasan">
                                                <i class="fas fa-check me-1"></i>Diulas
                                            </button>
                                        @else
                                            <span class="text-muted small">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($bookings->hasPages())
            <div class="mt-4 d-flex justify-content-center">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-inbox" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                <p class="text-muted">Anda belum memiliki booking.</p>
                <a href="{{ route('pencari.index') }}" class="btn btn-primary-gradient mt-3">Mulai Cari Kos</a>
            </div>
        @endif
    </div>

    <!-- Ulasan Saya -->
    <div class="glass-card">
        <h3 class="mb-4 fw-bold d-flex align-items-center">
            <i class="fas fa-star me-2 text-warning"></i>Ulasan Saya
        </h3>
        @if ($ulasan->count() > 0)
            <div class="row g-3">
                @foreach ($ulasan as $u)
                    <div class="col-md-6">
                        <div class="review-card">
                            <div class="review-header d-flex justify-content-between align-items-start mb-3">
                                <div class="flex-grow-1">
                                    <h5 class="card-title mb-1 fw-bold">{{ $u->kos->nama_kos }}</h5>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ \Carbon\Carbon::parse($u->tgl_ulasan)->diffForHumans() }}
                                    </small>
                                </div>
                                <form method="POST" action="{{ route('pencari.ulasan.destroy', $u->ulasan_id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus ulasan ini?')" title="Hapus ulasan">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="review-rating mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star{{ $i <= $u->rating ? '' : ' far' }}" style="color: {{ $i <= $u->rating ? '#ffc107' : '#ddd' }};"></i>
                                @endfor
                                <strong class="ms-2">{{ $u->rating }}/5</strong>
                            </div>

                            <p class="review-text mb-0">{{ $u->komentar ?: 'Tidak ada komentar' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-star-half-alt" style="font-size: 3rem; color: #ccc; margin-bottom: 1rem;"></i>
                <p class="text-muted">Anda belum memberikan ulasan apapun.</p>
                <a href="{{ route('pencari.dashboard') }}" class="btn btn-primary-gradient mt-3">Lihat Booking Selesai</a>
            </div>
        @endif
    </div>
</div>

<!-- Custom Styles untuk Dashboard -->
@push('styles')
<style>
    .stat-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .stat-card:hover {
        border-color: var(--primary-color);
        transform: translateY(-8px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        font-size: 1.5rem;
    }

    .stat-icon.primary { background: rgba(108, 99, 255, 0.1); color: var(--primary-color); }
    .stat-icon.success { background: rgba(40, 167, 69, 0.1); color: #28a745; }
    .stat-icon.info { background: rgba(23, 162, 184, 0.1); color: #17a2b8; }
    .stat-icon.warning { background: rgba(255, 193, 7, 0.1); color: #ffc107; }

    .booking-row:hover {
        background-color: rgba(108, 99, 255, 0.05);
    }

    .review-card {
        background: linear-gradient(135deg, rgba(255,255,255,0.6), rgba(255,255,255,0.3));
        border: 1px solid rgba(108, 99, 255, 0.1);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        border-left: 4px solid #ffc107;
    }

    .review-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(108, 99, 255, 0.15);
    }

    .review-header {
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(108, 99, 255, 0.1);
    }

    .review-rating {
        display: flex;
        align-items: center;
    }

    .review-text {
        font-size: 0.95rem;
        line-height: 1.6;
        color: var(--text-dark);
    }

    @media (max-width: 768px) {
        .btn-group-sm {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .btn-group-sm .btn {
            border-radius: 8px !important;
            margin-bottom: 4px;
        }
    }
</style>
@endpush

<!-- Script untuk interaktifitas -->
@push('scripts')
<script>
    // Ensure Bootstrap dropdown is initialized
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
        dropdownElements.forEach(element => {
            new bootstrap.Dropdown(element);
        });
    });

    // Smooth transitions untuk booking rows
    document.querySelectorAll('.booking-row').forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = 'rgba(108, 99, 255, 0.08)';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
</script>
@endpush
@endsection
