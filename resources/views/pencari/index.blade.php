@extends('layouts.app')

@section('title', 'Jelajahi Kost - Kost App')

@section('content')


    {{-- Main Content --}}
    <div class="explore-wrapper">
        <div class="container">
            <div class="page-header">
                <h2>Jelajahi Kost Tersedia</h2>
                <p>Temukan tempat hunian nyaman impianmu</p>
            </div>

            {{-- Category Filter --}}
            <div class="filter-container">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="putra">
                    <i class="fas fa-male me-1"></i> Putra
                </button>
                <button class="filter-btn" data-filter="putri">
                    <i class="fas fa-female me-1"></i> Putri
                </button>
                <button class="filter-btn" data-filter="campur">
                    <i class="fas fa-users me-1"></i> Campur
                </button>
            </div>

            <div class="row g-4" id="kost-grid">
                @foreach($kosts as $kost)
                <div class="col-lg-4 col-md-6 kost-item" data-category="{{ strtolower($kost->tipe_kos) }}">
                    <div class="kost-card">
                        <div class="kost-image-wrapper">
                            @if($kost->foto)
                                <img src="{{ asset('storage/' . $kost->foto) }}" class="kost-image" alt="{{ $kost->nama_kos }}">
                            @else
                                <img src="https://placehold.co/600x400/6C63FF/FFF?text=Foto+Kost" class="kost-image" alt="{{ $kost->nama_kos }}">
                            @endif

                            @php
                                $badgeClass = match($kost->tipe_kos) {
                                    'putra' => 'badge-putra',
                                    'putri' => 'badge-putri',
                                    'campur' => 'badge-campur',
                                    default => 'badge-putra'
                                };

                                $tipeIcon = match($kost->tipe_kos) {
                                    'putra' => 'fa-male',
                                    'putri' => 'fa-female',
                                    'campur' => 'fa-users',
                                    default => 'fa-home'
                                };
                            @endphp

                            <div class="kost-badge {{ $badgeClass }}">
                                <i class="fas {{ $tipeIcon }}"></i>
                                <span>{{ ucfirst($kost->tipe_kos) }}</span>
                            </div>
                        </div>

                        <div class="kost-body">
                            <h5 class="kost-title">{{ $kost->nama_kos }}</h5>

                            <div class="kost-location">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ Str::limit($kost->alamat, 45) }}</span>
                            </div>

                            <p class="kost-description">
                                {{ Str::limit($kost->deskripsi, 90) }}
                            </p>
                        </div>

                        <div class="kost-footer">
                            <a href="{{ route('pencari.show', $kost->kos_id) }}" class="btn-detail">
                                <span>Lihat Detail</span>
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                {{-- Empty State (Database Kosong) --}}
                @if($kosts->isEmpty())
                <div class="col-12">
                    <div class="empty-state visible">
                        <div class="empty-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h4 style="color: var(--text-dark); font-weight: 700;">Belum Ada Kost Tersedia</h4>
                        <p style="color: var(--text-muted);">Saat ini belum ada data kost yang tersedia. Silakan cek kembali nanti.</p>
                    </div>
                </div>
                @endif

                {{-- Empty State (Hasil Filter Kosong) --}}
                <div class="col-12" id="filter-empty-state" style="display: none;">
                    <div class="empty-state visible">
                        <div class="empty-icon">
                            <i class="fas fa-filter"></i>
                        </div>
                        <h4 style="color: var(--text-dark); font-weight: 700;">Tidak Ditemukan</h4>
                        <p style="color: var(--text-muted);">Tidak ada kost dengan kategori ini saat ini.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Javascript Logic untuk Filter --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterBtns = document.querySelectorAll('.filter-btn');
            const kostItems = document.querySelectorAll('.kost-item');
            const emptyState = document.getElementById('filter-empty-state');

            filterBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    // 1. Atur tombol aktif
                    filterBtns.forEach(b => b.classList.remove('active'));
                    btn.classList.add('active');

                    // 2. Ambil nilai filter
                    const filterValue = btn.getAttribute('data-filter');
                    let visibleCount = 0;

                    // 3. Loop item untuk show/hide
                    kostItems.forEach(item => {
                        const itemCategory = item.getAttribute('data-category');

                        if (filterValue === 'all' || filterValue === itemCategory) {
                            item.style.display = 'block';
                            // Reset animasi biar muncul smooth
                            item.style.animation = 'none';
                            item.offsetHeight; /* trigger reflow */
                            item.style.animation = 'fadeInUp 0.6s ease forwards';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });

                    // 4. Cek Empty State
                    if (visibleCount === 0) {
                        emptyState.style.display = 'block';
                    } else {
                        emptyState.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endsection
