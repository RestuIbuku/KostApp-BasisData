@extends('layouts.app')

@section('title', 'Ulasan Kos - Kost App')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="glass-card">
                <h2 class="mb-4">{{ $kos->nama_kos }} - Ulasan Pengunjung</h2>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="text-center">
                            <h3 class="text-primary">{{ number_format($avgRating, 1) }}/5</h3>
                            <div class="mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star" style="color: {{ $i <= round($avgRating) ? '#ffc107' : '#ccc' }};"></i>
                                @endfor
                            </div>
                            <p class="text-muted">{{ $totalReviews }} ulasan</p>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="row text-center">
                            @for($rating = 5; $rating >= 1; $rating--)
                                <div class="col-6 mb-2">
                                    <small class="text-muted">⭐ {{ $rating }}:</small>
                                    <span class="badge bg-primary">{{ $ratingDistribution[$rating]->count ?? 0 }}</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <hr>

                @if($reviews->isEmpty())
                    <p class="text-muted">Belum ada ulasan.</p>
                @else
                    @foreach($reviews as $review)
                        <div class="mb-4 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">
                                        <strong>{{ $review->pencari->nama_lengkap }}</strong>
                                        <span class="badge bg-warning text-dark ms-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star" style="font-size: 0.8rem; color: {{ $i <= $review->rating ? '#ffc107' : '#ccc' }};"></i>
                                            @endfor
                                        </span>
                                    </h6>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($review->tgl_ulasan)->diffForHumans() }}</small>
                                </div>
                            </div>
                            <p class="mb-0 mt-2">{{ $review->komentar }}</p>
                        </div>
                    @endforeach

                    {{ $reviews->links() }}
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
