<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajahi Kost - Kost App</title>

    {{-- Font Awesome & Google Fonts --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6C63FF;
            --primary-hover: #5a52d5;
            --secondary-color: #FF6584;
            --text-dark: #2D3436;
            --text-muted: #636e72;
            --glass-bg: rgba(255, 255, 255, 0.65);
            --glass-border: rgba(255, 255, 255, 0.4);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
            color: var(--text-dark);
        }

        /* --- Animated Background Blobs --- */
        .background-shapes {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }

        .shape {
            position: absolute;
            filter: blur(60px);
            opacity: 0.5;
            animation: float 10s infinite ease-in-out alternate;
        }

        .shape-1 {
            top: -10%;
            right: -5%;
            width: 600px;
            height: 600px;
            background: var(--primary-color);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .shape-2 {
            bottom: -10%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: var(--secondary-color);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(30px, 50px) rotate(10deg); }
        }

        /* --- Glass Navbar --- */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            padding: 1rem 0;
        }

        .brand-text {
            font-weight: 700;
            font-size: 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 99, 255, 0.4);
            color: white;
        }

        /* --- Layout Styling --- */
        .explore-wrapper {
            padding: 120px 0 5rem; 
            position: relative;
            z-index: 1;
        }

        .page-header {
            text-align: center;
            margin-bottom: 2.5rem;
            animation: fadeInDown 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
        }

        .page-header h2 {
            color: var(--text-dark);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        /* --- Filter Tabs --- */
        .filter-container {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 3rem;
            flex-wrap: wrap;
            animation: fadeInDown 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) 0.1s backwards;
        }

        .filter-btn {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid var(--glass-border);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .filter-btn:hover {
            background: white;
            transform: translateY(-2px);
            color: var(--primary-color);
        }

        .filter-btn.active {
            background: var(--primary-color);
            color: white;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            border-color: transparent;
        }

        /* --- Glassmorphism Card --- */
        .kost-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
            /* Animation removed from here to handle filtering smoothly */
        }

        .kost-item {
            animation: fadeInUp 0.6s ease forwards;
        }

        .kost-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(108, 99, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.8);
        }

        /* Image Area */
        .kost-image-wrapper {
            position: relative;
            height: 220px;
            overflow: hidden;
        }

        .kost-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .kost-card:hover .kost-image {
            transform: scale(1.1);
        }

        /* Badge Styling */
        .kost-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.4rem 1rem;
            border-radius: 12px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(4px);
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .badge-putra { color: var(--primary-color); border: 2px solid var(--primary-color); }
        .badge-putri { color: var(--secondary-color); border: 2px solid var(--secondary-color); }
        .badge-campur { color: #00b894; border: 2px solid #00b894; }

        /* Card Body */
        .kost-body {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .kost-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .kost-location {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .kost-location i {
            color: var(--primary-color);
            margin-top: 3px;
        }

        .kost-description {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Footer & Button */
        .kost-footer {
            padding: 0 1.5rem 1.5rem;
            margin-top: auto;
        }

        .btn-detail {
            width: 100%;
            padding: 0.8rem;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            border-radius: 16px;
            color: white;
            font-weight: 600;
            font-size: 0.95rem;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
        }

        .btn-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
            color: white;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            display: none; /* Hidden by default, shown by JS or blade */
        }
        
        .empty-state.visible {
            display: block;
            animation: fadeInUp 0.5s ease;
        }

        .empty-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(135deg, var(--primary-color), #a29bfe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 20px rgba(108, 99, 255, 0.3);
        }

        /* Animations */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    {{-- Animated Background Blobs --}}
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand brand-text" href="{{ route('home') }}">
                <i class="fas fa-house-user me-2"></i>KostApp
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto d-flex align-items-center gap-3">
                    @auth
                        <div class="dropdown">
                            <button class="btn border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px; color: var(--primary-color); font-weight: bold;">
                                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="d-none d-md-block fw-medium small">{{ Str::limit(Auth::user()->nama_lengkap, 10) }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 mt-2 p-2" style="background: rgba(255,255,255,0.95);">
                                <li><h6 class="dropdown-header text-muted">Akun Saya</h6></li>
                                <li><a class="dropdown-item rounded-3" href="{{ route('profile') }}"><i class="fas fa-user me-2 text-primary"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3 text-danger" href="{{ route('logout') }}" onclick="return confirm('Logout sekarang?')"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary-gradient btn-sm px-4">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

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
</body>
</html>