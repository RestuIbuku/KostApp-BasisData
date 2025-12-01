@extends('layouts.app')

@section('title', 'Ulasan Kos - Kost App')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Ulasan untuk {{ $kos->nama_kos }}</h3>

    <div class="glass-card">
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="text-center p-3 border-bottom">
                    <h3 class="text-primary">{{ number_format($avgRating, 1) }}/5</h3>
                    <div class="mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star" style="color: {{ $i <= round($avgRating) ? '#ffc107' : '#ccc' }};"></i>
                        @endfor
                    </div>
                    <p class="text-muted mb-0">{{ $totalReviews }} ulasan</p>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row text-center">
                    @for($rating = 5; $rating >= 1; $rating--)
                        <div class="col-6 col-md-2 mb-2">
                            <small class="text-muted d-block">⭐ {{ $rating }}</small>
                            <span class="badge bg-primary">{{ $ratingDistribution[$rating]->count ?? 0 }}</span>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <hr>

        @if($reviews->isEmpty())
            <p class="text-muted">Belum ada ulasan untuk kos ini.</p>
        @else
            @foreach($reviews as $review)
                <div class="mb-4 pb-3 border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div style="flex: 1;">
                            <h6 class="mb-1">
                                <strong>{{ $review->pencari->nama_lengkap }}</strong>
                                <span class="badge bg-warning text-dark ms-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star" style="font-size: 0.8rem; color: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }};"></i>
                                    @endfor
                                </span>
                            </h6>
                            <p class="mb-0">{{ $review->komentar }}</p>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($review->tgl_ulasan)->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            @endforeach

            {{ $reviews->links() }}
        @endif
    </div>

    <a href="{{ route('pemilik.reviews.index') }}" class="btn btn-outline-custom mt-3">Kembali ke Semua Ulasan</a>
</div>
@endsection
