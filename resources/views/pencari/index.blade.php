@extends('layouts.app')

@section('title', 'Jelajahi Kost - Kost App')

@section('content')
<style>
    :root {
        --primary-color: #6C63FF;
        --primary-dark: #5852CC;
        --secondary-color: #FF6584;
        --success-color: #4CAF50;
        --text-dark: #2D3436;
        --text-muted: #636E72;
        --bg-light: #F8F9FA;
        --border-color: #E9ECEF;
        --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.08);
        --shadow-md: 0 4px 16px rgba(0, 0, 0, 0.12);
        --shadow-lg: 0 8px 24px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Page Header */
    .explore-wrapper {
        padding: 2.5rem 0 4rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
    }

    .page-header {
        text-align: center;
        margin-bottom: 2.5rem;
        padding: 0 1rem;
    }

    .page-header h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #fff;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .page-header p {
        font-size: 1.125rem;
        color: rgba(255, 255, 255, 0.9);
        font-weight: 400;
    }

    /* Search & Filter Card */
    .card {
        border: none;
        border-radius: 16px;
        overflow: hidden;
        background: #fff;
        transition: var(--transition);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 2px solid var(--border-color);
        border-radius: 10px;
        padding: 0.75rem 1rem;
        font-size: 0.95rem;
        transition: var(--transition);
        background: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
        outline: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3);
        color: #fff;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
        color: #fff;
    }

    /* Filter Buttons */
    .filter-container {
        display: flex;
        gap: 1rem;
        margin-bottom: 2.5rem;
        flex-wrap: wrap;
        justify-content: center;
        padding: 0 1rem;
    }

    .filter-btn {
        padding: 0.75rem 1.75rem;
        border: 2px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        backdrop-filter: blur(10px);
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .filter-btn:hover {
        background: rgba(255, 255, 255, 0.25);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .filter-btn.active {
        background: #fff;
        color: var(--primary-color);
        border-color: #fff;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
    }

    /* Kost Card */
    .kost-item {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .kost-item:nth-child(1) { animation-delay: 0.1s; }
    .kost-item:nth-child(2) { animation-delay: 0.2s; }
    .kost-item:nth-child(3) { animation-delay: 0.3s; }
    .kost-item:nth-child(4) { animation-delay: 0.4s; }
    .kost-item:nth-child(5) { animation-delay: 0.5s; }
    .kost-item:nth-child(6) { animation-delay: 0.6s; }

    .kost-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .kost-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-lg);
    }

    .kost-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 240px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kost-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--transition);
    }

    .kost-image-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        font-size: 3rem;
    }

    .kost-card:hover .kost-image {
        transform: scale(1.08);
    }

    .kost-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.4rem;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .badge-putra {
        background: rgba(52, 152, 219, 0.95);
        color: #fff;
    }

    .badge-putri {
        background: rgba(255, 101, 132, 0.95);
        color: #fff;
    }

    .badge-campur {
        background: rgba(155, 89, 182, 0.95);
        color: #fff;
    }

    .kost-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .kost-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        line-height: 1.4;
    }

    .kost-location {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        color: var(--text-muted);
        font-size: 0.9rem;
        margin-bottom: 1rem;
    }

    .kost-location i {
        color: var(--secondary-color);
        margin-top: 0.15rem;
    }

    .kost-description {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.6;
        margin-bottom: 1rem;
        flex: 1;
    }

    .kost-price {
        display: flex;
        flex-direction: column;
        padding: 1rem;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 12px;
        margin-top: auto;
    }

    .kost-price .text-muted {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin-bottom: 0.25rem;
    }

    .kost-price strong {
        font-size: 1.25rem;
        color: var(--primary-color);
        font-weight: 700;
    }

    .kost-footer {
        padding: 1.25rem 1.5rem;
        border-top: 1px solid var(--border-color);
    }

    .btn-detail {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        padding: 0.875rem 1.25rem;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: #fff;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 600;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3);
    }

    .btn-detail:hover {
        transform: translateX(4px);
        box-shadow: 0 6px 20px rgba(108, 99, 255, 0.4);
        color: #fff;
    }

    .btn-detail i {
        transition: var(--transition);
    }

    .btn-detail:hover i {
        transform: translateX(4px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        box-shadow: var(--shadow-sm);
    }

    .empty-icon {
        width: 120px;
        height: 120px;
        margin: 0 auto 1.5rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .empty-icon i {
        font-size: 3.5rem;
        color: #fff;
    }

    .empty-state h4 {
        font-size: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        font-size: 1rem;
        max-width: 400px;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header h2 {
            font-size: 2rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .filter-container {
            gap: 0.75rem;
        }

        .filter-btn {
            padding: 0.625rem 1.25rem;
            font-size: 0.875rem;
        }

        .kost-image-wrapper {
            height: 200px;
        }
    }
</style>

{{-- Main Content --}}
<div class="explore-wrapper">
    <div class="container">
        <div class="page-header">
            <h2>Jelajahi Kost Tersedia</h2>
            <p>Temukan tempat hunian nyaman impianmu</p>
        </div>

        {{-- Search & Filter Form --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <form method="GET" action="{{ route('pencari.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="nama" class="form-label">Nama Kost</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Cari nama kost..." value="{{ request('nama') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tipe" class="form-label">Tipe Kost</label>
                        <select class="form-select" id="tipe" name="tipe">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="putra" {{ request('tipe') == 'putra' ? 'selected' : '' }}>Putra</option>
                            <option value="putri" {{ request('tipe') == 'putri' ? 'selected' : '' }}>Putri</option>
                            <option value="campur" {{ request('tipe') == 'campur' ? 'selected' : '' }}>Campur</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="min_harga" class="form-label">Min. Harga</label>
                        <input type="number" class="form-control" id="min_harga" name="min_harga" placeholder="Min..." value="{{ request('min_harga') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="max_harga" class="form-label">Max. Harga</label>
                        <input type="number" class="form-control" id="max_harga" name="max_harga" placeholder="Max..." value="{{ request('max_harga') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Cari</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Category Filter Buttons --}}
        <div class="filter-container">
            <button class="filter-btn active" data-filter="all">
                <i class="fas fa-th"></i>
                <span>Semua</span>
            </button>
            <button class="filter-btn" data-filter="putra">
                <i class="fas fa-male"></i>
                <span>Putra</span>
            </button>
            <button class="filter-btn" data-filter="putri">
                <i class="fas fa-female"></i>
                <span>Putri</span>
            </button>
            <button class="filter-btn" data-filter="campur">
                <i class="fas fa-users"></i>
                <span>Campur</span>
            </button>
        </div>

        <div class="row g-4" id="kost-grid">
            @foreach($kosts as $kost)
            <div class="col-lg-4 col-md-6 kost-item" data-category="{{ strtolower($kost->tipe_kos) }}">
                <div class="kost-card">
                    <div class="kost-image-wrapper">
                        @if($kost->foto)
                            @php
                                $fotoPath = $kost->foto;
                                // Jika path sudah lengkap (http), gunakan langsung
                                if (Str::startsWith($fotoPath, 'http')) {
                                    $imageSrc = $fotoPath;
                                } else {
                                    // Jika belum, tambahkan storage path
                                    $imageSrc = asset('storage/' . $fotoPath);
                                }
                            @endphp
                            <img src="{{ $imageSrc }}"
                                 class="kost-image"
                                 alt="{{ $kost->nama_kos }}"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="kost-image-placeholder" style="display: none;">
                                <i class="fas fa-image"></i>
                            </div>
                        @else
                            <div class="kost-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
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

                        @php
                            $minHarga = $kost->kamar->min('harga_per_malam');
                        @endphp
                        @if ($minHarga)
                        <div class="kost-price">
                            <span class="text-muted">Mulai dari</span>
                            <strong>Rp {{ number_format($minHarga, 0, ',', '.') }}/malam</strong>
                        </div>
                        @endif
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

        {{-- Pagination --}}
        @if ($kosts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $kosts->links() }}
        </div>
        @endif
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
