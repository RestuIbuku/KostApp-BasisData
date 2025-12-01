@extends('layouts.app')

@section('title', 'Riwayat Booking - Kost App')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="glass-card">
                <h3 class="mb-4">Riwayat Booking Saya</h3>

                @if($bookings->isEmpty())
                    <p class="text-muted">Belum ada booking.</p>
                @else
                    <div class="list-group">
                        @foreach($bookings as $b)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-1">{{ $b->kamar->nama_kamar }} <small class="text-muted">({{ $b->kamar->kos->nama_kos }})</small></h5>
                                    <p class="mb-0 small">{{ \Carbon\Carbon::parse($b->tgl_mulai_sewa)->format('d M Y') }} — {{ \Carbon\Carbon::parse($b->tgl_selesai_sewa)->format('d M Y') }}</p>
                                    <p class="mb-0 small">Total: Rp {{ number_format($b->total_harga,0,',','.') }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-{{ $b->status_booking=='pending' ? 'warning' : ($b->status_booking=='confirmed' ? 'primary' : ($b->status_booking=='completed' ? 'success' : 'danger')) }} mb-2">{{ ucfirst($b->status_booking) }}</span>
                                    <div>
                                        <a href="{{ route('pencari.dashboard') }}" class="btn btn-outline-custom btn-sm">Detail</a>
                                        @if($b->status_booking == 'pending')
                                            <form method="POST" action="{{ route('pencari.booking.cancel', $b->booking_id) }}" class="d-inline">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Batalkan booking ini?')">Batal</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4">{{ $bookings->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
