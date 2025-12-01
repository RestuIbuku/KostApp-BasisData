@extends('layouts.app')

@section('title', 'Beri Ulasan - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass-card">
                <h3 class="mb-4">Beri Ulasan untuk {{ $booking->kamar->kos->nama_kos }}</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card mb-4">
                    <div class="card-body">
                        <p><strong>Kamar:</strong> {{ $booking->kamar->nama_kamar }}</p>
                        <p><strong>Tanggal Sewa:</strong> {{ \Carbon\Carbon::parse($booking->tgl_mulai_sewa)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tgl_selesai_sewa)->format('d M Y') }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('pencari.ulasan.store') }}">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->booking_id }}">

                    <div class="mb-3">
                        <label class="form-label">Rating (1-5 Bintang)</label>
                        <div class="d-flex gap-2" id="ratingStars">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" class="d-none" required>
                                <label for="rating{{ $i }}" class="rating-star" data-rating="{{ $i }}" style="cursor: pointer; font-size: 2rem;">
                                    <i class="fas fa-star" style="color: #ffc107; opacity: 0.3; transition: opacity 0.2s;"></i>
                                </label>
                            @endfor
                        </div>
                        @error('rating') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar (Opsional)</label>
                        <textarea id="komentar" name="komentar" class="form-control" rows="5" placeholder="Bagikan pengalaman Anda...">{{ old('komentar') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary-gradient w-100">Kirim Ulasan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Interactive star rating
    const stars = document.querySelectorAll('.rating-star');
    const ratingInputs = document.querySelectorAll('input[name="rating"]');

    stars.forEach(star => {
        star.addEventListener('mouseenter', function() {
            const rating = this.dataset.rating;
            stars.forEach(s => {
                if (s.dataset.rating <= rating) {
                    s.querySelector('i').style.opacity = '1';
                } else {
                    s.querySelector('i').style.opacity = '0.3';
                }
            });
        });
    });

    document.getElementById('ratingStars').addEventListener('mouseleave', function() {
        const checked = document.querySelector('input[name="rating"]:checked');
        stars.forEach(s => {
            if (checked && s.dataset.rating <= checked.value) {
                s.querySelector('i').style.opacity = '1';
            } else {
                s.querySelector('i').style.opacity = '0.3';
            }
        });
    });

    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            stars.forEach(s => {
                if (s.dataset.rating <= this.value) {
                    s.querySelector('i').style.opacity = '1';
                } else {
                    s.querySelector('i').style.opacity = '0.3';
                }
            });
        });
    });
</script>
@endsection
