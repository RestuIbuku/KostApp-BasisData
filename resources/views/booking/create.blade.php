@extends('layouts.app')

@section('title', 'Form Booking - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card">
                <h1 class="mb-4">Form Booking Kamar</h1>

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
                        <h5 class="card-title">Detail Kamar</h5>
                        <p><strong>Nama Kamar:</strong> {{ $kamar->nama_kamar }}</p>
                        <p><strong>Harga per Malam:</strong> Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</p>
                        <p><strong>Ukuran:</strong> {{ $kamar->ukuran_kamar ?? 'N/A' }}</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-{{ $kamar->status_ketersediaan == 'tersedia' ? 'success' : 'danger' }}">
                                {{ ucfirst($kamar->status_ketersediaan) }}
                            </span>
                        </p>
                    </div>
                </div>

                <form method="POST" action="{{ route('pencari.booking.store') }}">
                    @csrf
                    <input type="hidden" name="kamar_id" value="{{ $kamar->kamar_id }}">

                    <div class="mb-3">
                        <label for="tgl_mulai_sewa" class="form-label">Tanggal Mulai Sewa</label>
                        <input type="date" id="tgl_mulai_sewa" name="tgl_mulai_sewa" class="form-control" required value="{{ old('tgl_mulai_sewa') }}">
                    </div>

                    <div class="mb-3">
                        <label for="tgl_selesai_sewa" class="form-label">Tanggal Selesai Sewa</label>
                        <input type="date" id="tgl_selesai_sewa" name="tgl_selesai_sewa" class="form-control" required value="{{ old('tgl_selesai_sewa') }}">
                    </div>

                    <div class="alert alert-info">
                        <strong>Perkiraan Total Harga:</strong> <span id="total_harga">Rp 0</span>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Lanjut ke Pembayaran</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const hargaPerMalam = {{ $kamar->harga_per_malam }};
    const mulaiInput = document.getElementById('tgl_mulai_sewa');
    const selesaiInput = document.getElementById('tgl_selesai_sewa');
    const totalHargaEl = document.getElementById('total_harga');

    function hitungTotal() {
        if (mulaiInput.value && selesaiInput.value) {
            const mulai = new Date(mulaiInput.value);
            const selesai = new Date(selesaiInput.value);
            const hari = Math.ceil((selesai - mulai) / (1000 * 60 * 60 * 24)) + 1;
            const total = hari * hargaPerMalam;
            totalHargaEl.textContent = 'Rp ' + total.toLocaleString('id-ID');
        }
    }

    mulaiInput.addEventListener('change', hitungTotal);
    selesaiInput.addEventListener('change', hitungTotal);
</script>
@endsection
