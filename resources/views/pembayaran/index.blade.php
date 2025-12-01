@extends('layouts.app')

@section('title', 'Pembayaran - Kost App')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Ringkasan Pembayaran Masuk</h3>

    <div class="glass-card">
        @if($pembayaran->isEmpty())
            <p class="text-muted">Belum ada pembayaran.</p>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Penyewa</th>
                            <th>Kamar</th>
                            <th>Jumlah</th>
                            <th>Metode</th>
                            <th>Tanggal Bayar</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pembayaran as $p)
                            <tr>
                                <td>{{ $p->booking->pencari->nama_lengkap }}</td>
                                <td>{{ $p->booking->kamar->nama_kamar }} ({{ $p->booking->kamar->kos->nama_kos }})</td>
                                <td>Rp {{ number_format($p->jumlah, 0, ',', '.') }}</td>
                                <td>{{ $p->metode_pembayaran }}</td>
                                <td>{{ \Carbon\Carbon::parse($p->tgl_pembayaran)->format('d M Y H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $p->status_pembayaran == 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($p->status_pembayaran) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-3">{{ $pembayaran->links() }}</div>
        @endif
    </div>
</div>
@endsection
