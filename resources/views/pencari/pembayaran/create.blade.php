@extends('layouts.app')

@section('title', 'Form Pembayaran - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card">
                <h1 class="mb-4">Konfirmasi Pembayaran</h1>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Detail Booking</h5>
                        <p><strong>Kamar:</strong> {{ $booking->kamar->nama_kamar }}</p>
                        <p><strong>Mulai Sewa:</strong> {{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y') }}</p>
                        <p><strong>Selesai Sewa:</strong> {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y') }}</p>
                        <hr>
                        <h4 class="text-primary"><strong>Total Pembayaran: Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong></h4>
                    </div>
                </div>

                <form method="POST" action="{{ route('pembayaran.store', $booking->booking_id) }}">
                    @csrf

                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select id="metode_pembayaran" name="metode_pembayaran" class="form-select" required>
                            <option value="">-- Pilih Metode --</option>
                            <option value="bca">Transfer BCA</option>
                            <option value="mandiri">Transfer Mandiri</option>
                            <option value="bni">Transfer BNI</option>
                            <option value="pulsa">Transfer Pulsa / E-Wallet</option>
                            <option value="cash">Tunai</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" value="{{ $booking->total_harga }}" readonly>
                    </div>

                    <div class="alert alert-warning">
                        <i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Ini adalah simulasi pembayaran. Setelah submit, booking Anda akan dikonfirmasi.
                    </div>

                    <button type="submit" class="btn btn-success w-100 btn-lg">
                        <i class="fas fa-check"></i> Konfirmasi Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
