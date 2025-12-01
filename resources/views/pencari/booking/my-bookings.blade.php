@extends('layouts.app')

@section('title', 'Riwayat Booking - Kost App')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="glass-card">
                <h3 class="mb-4"><i class="fas fa-calendar-check me-2"></i>Riwayat Booking Saya</h3>

                @if($bookings->isEmpty())
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> Anda belum memiliki booking. <a href="{{ route('pencari.index') }}">Jelajahi kos sekarang</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Kamar</th>
                                    <th>Kos</th>
                                    <th>Periode Sewa</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $b)
                                    <tr>
                                        <td><strong>{{ $b->kamar->nama_kamar }}</strong></td>
                                        <td>{{ $b->kamar->kos->nama_kos }}</td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($b->tgl_mulai_sewa)->format('d M Y') }} <br>
                                            s/d {{ \Carbon\Carbon::parse($b->tgl_selesai_sewa)->format('d M Y') }}
                                        </td>
                                        <td>Rp {{ number_format($b->total_harga,0,',','.') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $b->status_booking=='pending' ? 'warning' : ($b->status_booking=='confirmed' ? 'success' : ($b->status_booking=='completed' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($b->status_booking) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($b->status_booking == 'pending')
                                                <a href="{{ route('pencari.pembayaran.create', $b->booking_id) }}" class="btn btn-sm btn-primary" title="Lanjut Bayar">
                                                    <i class="fas fa-credit-card"></i> Bayar
                                                </a>
                                                <form method="POST" action="{{ route('pencari.booking.cancel', $b->booking_id) }}" style="display: inline;">
                                                    @csrf
                                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Batalkan booking ini?')" title="Batalkan Booking">
                                                        <i class="fas fa-times"></i> Batal
                                                    </button>
                                                </form>
                                            @elseif($b->status_booking == 'confirmed')
                                                <span class="badge bg-secondary">Sudah Dibayar</span>
                                            @elseif($b->status_booking == 'completed' && !$b->ulasan)
                                                <a href="{{ route('pencari.ulasan.create', $b->booking_id) }}" class="btn btn-sm btn-warning" title="Beri Ulasan">
                                                    <i class="fas fa-star"></i> Ulasan
                                                </a>
                                            @elseif($b->ulasan)
                                                <span class="badge bg-info"><i class="fas fa-check"></i> Sudah Diulas</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $bookings->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
