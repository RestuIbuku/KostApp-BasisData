@extends('layouts.app')

@section('title', 'Detail Kost - Kost App')

@section('content')

    <div class="detail-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    {{-- BREADCRUMB --}}
                    <div class="breadcrumb-wrapper">
                        <div class="custom-breadcrumb">
                            <a href="{{ route('pencari.index') }}"><i class="fas fa-search me-1"></i> Jelajahi</a>
                            <span class="breadcrumb-divider">/</span>
                            <span class="active">Detail Kost</span>
                        </div>
                    </div>

                    <div class="glass-card">

                        {{-- GAMBAR UTAMA --}}
                        <div class="hero-image-wrapper">
                            @if($kost->foto)
                                @if(Str::startsWith($kost->foto, 'http'))
                                    <img src="{{ $kost->foto }}" class="hero-image" alt="Foto Kost">
                                @else
                                    <img src="{{ asset('storage/' . $kost->foto) }}" class="hero-image" alt="Foto Kost">
                                @endif
                            @else
                                <img src="https://placehold.co/800x400/e2e8f0/94a3b8?text=Foto+Tidak+Tersedia" class="hero-image" alt="Placeholder">
                            @endif

                            <div class="image-overlay-gradient"></div>

                            {{-- Badge Tipe Kost --}}
                            @php
                                $textClass = match($kost->tipe_kos) {
                                    'putra' => 'text-putra',
                                    'putri' => 'text-putri',
                                    'campur' => 'text-campur',
                                    default => 'text-putra'
                                };
                                $icon = match($kost->tipe_kos) {
                                    'putra' => 'fa-male',
                                    'putri' => 'fa-female',
                                    'campur' => 'fa-users',
                                    default => 'fa-home'
                                };
                            @endphp
                            <div class="badge-float">
                                <i class="fas {{ $icon }} {{ $textClass }}"></i>
                                <span class="{{ $textClass }}">Kost {{ ucfirst($kost->tipe_kos) }}</span>
                            </div>
                        </div>

                        <div class="content-body">
                            {{-- HEADER INFO --}}
                            <div class="mb-4">
                                <h1 class="kost-title">{{ $kost->nama_kos }}</h1>
                                <div class="kost-address">
                                    <i class="fas fa-map-marker-alt mt-1 text-danger"></i>
                                    <span>{{ $kost->alamat }}</span>
                                </div>
                            </div>

                            <hr class="my-4" style="opacity: 0.15;">

                            {{-- DESKRIPSI --}}
                            <div class="mb-4">
                                <h5 class="section-title"><i class="fas fa-align-left text-primary"></i>Deskripsi & Fasilitas</h5>
                                <p class="description-text">
                                    {{ $kost->deskripsi ?: 'Tidak ada deskripsi yang tersedia untuk kost ini. Silakan hubungi pemilik untuk informasi lebih lanjut.' }}
                                </p>
                            </div>

                            {{-- JUMLAH KAMAR KOSONG --}}
                            <div class="mb-5">
                                <h5 class="section-title"><i class="fas fa-door-open" style="color: #e17055;"></i>Kamar Tersedia</h5>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-white rounded-3 p-3 shadow-sm border" style="min-width: 120px; text-align: center;">
                                        <div class="fs-2 fw-bold" style="color: var(--primary-color);">{{ $kost->jumlah_kamar_kosong }}</div>
                                        <small class="text-muted">Kamar Kosong</small>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="description-text mb-0">
                                            @if($kost->jumlah_kamar_kosong > 0)
                                                Kost ini memiliki <strong>{{ $kost->jumlah_kamar_kosong }}</strong> kamar yang tersedia untuk disewa. Segera hubungi pemilik untuk informasi lebih lanjut.
                                            @else
                                                Saat ini tidak ada kamar kosong yang tersedia. Silakan cek kembali nanti atau hubungi pemilik untuk informasi update.
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- DAFTAR KAMAR --}}
                            <div class="mb-5">
                                <h5 class="section-title"><i class="fas fa-th-large" style="color: var(--primary-color);"></i>Pilih Kamar</h5>
                                @if($kamarList && count($kamarList) > 0)
                                    <div class="row g-3">
                                        @foreach($kamarList as $kamar)
                                        <div class="col-md-6">
                                            <div class="kamar-card">
                                                {{-- FOTO KAMAR --}}
                                                @if($kamar->fotoKamar && count($kamar->fotoKamar) > 0)
                                                    <div id="carousel-{{ $kamar->kamar_id }}" class="carousel slide kamar-photo" data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            @foreach($kamar->fotoKamar as $key => $foto)
                                                            <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                                                <img src="{{ asset('storage/' . $foto->url_foto) }}" alt="Foto {{ $kamar->nama_kamar }}" class="d-block w-100">
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        @if(count($kamar->fotoKamar) > 1)
                                                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $kamar->kamar_id }}" data-bs-slide="prev">
                                                            <span class="carousel-control-prev-icon"></span>
                                                        </button>
                                                        <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $kamar->kamar_id }}" data-bs-slide="next">
                                                            <span class="carousel-control-next-icon"></span>
                                                        </button>
                                                        @endif
                                                    </div>
                                                @else
                                                    <img src="https://placehold.co/400x300/e2e8f0/94a3b8?text=Tidak+Ada+Foto" alt="Placeholder" class="w-100">
                                                @endif

                                                {{-- INFO KAMAR --}}
                                                <div class="kamar-info">
                                                    <h6 class="kamar-name">{{ $kamar->nama_kamar }}</h6>
                                                    <p class="kamar-size mb-2"><i class="fas fa-ruler-combined"></i> {{ $kamar->ukuran_kamar }}</p>

                                                    {{-- FASILITAS --}}
                                                    @if($kamar->fasilitas && count($kamar->fasilitas) > 0)
                                                    <div class="kamar-facilities mb-2">
                                                        @foreach($kamar->fasilitas->take(3) as $fas)
                                                        <span class="badge-facility"><i class="fas fa-check-circle"></i> {{ $fas->nama_fasilitas }}</span>
                                                        @endforeach
                                                        @if($kamar->fasilitas->count() > 3)
                                                        <span class="badge-facility"><i class="fas fa-plus"></i> {{ $kamar->fasilitas->count() - 3 }} lebih</span>
                                                        @endif
                                                    </div>
                                                    @endif

                                                    {{-- HARGA & STATUS --}}
                                                    <div class="kamar-footer">
                                                        <div>
                                                            <div class="kamar-price">Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</div>
                                                            <small class="text-muted">/Malam</small>
                                                        </div>
                                                        @if($kamar->status_ketersediaan === 'tersedia')
                                                            @auth
                                                            <a href="{{ route('pencari.booking.create', $kamar->kamar_id) }}" class="btn-booking-kamar">
                                                                Booking
                                                            </a>
                                                            @else
                                                            <a href="{{ route('login') }}" class="btn-booking-kamar">
                                                                Login untuk Booking
                                                            </a>
                                                            @endauth
                                                        @else
                                                            <span class="badge bg-danger">Penuh</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="empty-state-small">
                                        <i class="fas fa-inbox"></i>
                                        <p>Belum ada kamar yang terdaftar untuk kost ini</p>
                                    </div>
                                @endif
                            </div>

                            {{-- KONTAK PEMILIK --}}
                            <div class="owner-box">
                                <div class="d-flex align-items-center gap-3 justify-content-center justify-content-md-start">
                                    <div class="owner-avatar">
                                        <i class="fas fa-user-tie"></i>
                                    </div>
                                    <div>
                                        <span class="d-block small text-muted text-uppercase fw-bold">Pemilik Kost</span>
                                        <h5 class="mb-0 fw-bold" style="color: var(--text-dark);">{{ $kost->pemilik->nama_lengkap }}</h5>
                                    </div>
                                </div>

                                <div>
                                    <a href="https://wa.me/{{ $formattedPhone }}?text=Halo,%20saya%20tertarik%20dengan%20kost%20{{ urlencode($kost->nama_kos) }}" target="_blank" class="btn-whatsapp">
                                        <i class="fab fa-whatsapp fa-lg"></i>
                                        Hubungi via WhatsApp
                                    </a>
                                </div>
                            </div>

                            {{-- SECTION ULASAN --}}
                            <hr class="my-5" style="opacity: 0.15;">

                            <div class="mb-5">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <h5 class="section-title mb-0"><i class="fas fa-star text-warning"></i> Ulasan Pengguna</h5>
                                    @auth
                                    <a href="{{ route('pencari.reviews', $kost->kos_id) }}" class="btn btn-sm btn-primary-gradient">
                                        <i class="fas fa-eye me-1"></i>Lihat Semua
                                    </a>
                                    @endauth
                                </div>

                                @if($kost->ulasan && count($kost->ulasan) > 0)
                                    <div class="reviews-container">
                                        @foreach($kost->ulasan->take(3) as $ulasan)
                                            <div class="review-item mb-3 p-4" style="background: rgba(255,255,255,0.5); border-left: 4px solid #ffc107; border-radius: 12px;">
                                                <div class="d-flex justify-content-between align-items-start mb-2">
                                                    <div>
                                                        <h6 class="fw-bold mb-1">{{ $ulasan->user->nama_lengkap }}</h6>
                                                        <small class="text-muted">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            {{ \Carbon\Carbon::parse($ulasan->tgl_ulasan)->diffForHumans() }}
                                                        </small>
                                                    </div>
                                                    <div class="review-rating">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star{{ $i <= $ulasan->rating ? '' : ' far' }}" style="color: {{ $i <= $ulasan->rating ? '#ffc107' : '#ddd' }}; font-size: 0.9rem;"></i>
                                                        @endfor
                                                        <strong class="ms-2" style="font-size: 0.9rem;">{{ $ulasan->rating }}/5</strong>
                                                    </div>
                                                </div>
                                                <p class="mb-0 text-dark" style="font-size: 0.95rem; line-height: 1.6;">
                                                    {{ Str::limit($ulasan->komentar, 150) }}
                                                </p>
                                            </div>
                                        @endforeach

                                        @if($kost->ulasan->count() > 3)
                                            <div class="text-center mt-4">
                                                <a href="{{ route('pencari.reviews', $kost->kos_id) }}" class="btn btn-outline-custom">
                                                    <i class="fas fa-arrow-right me-2"></i>Lihat {{ $kost->ulasan->count() }} Ulasan Lengkap
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <i class="fas fa-comment-slash" style="font-size: 2rem; color: #ccc; margin-bottom: 1rem;"></i>
                                        <p class="text-muted">Belum ada ulasan untuk kost ini. Jadilah yang pertama memberikan ulasan!</p>
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
