<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kost - Kost App</title>

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
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.5);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            position: relative;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* === Animated Background Blobs === */
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

        /* === Navbar Glass === */
        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
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

        /* === Layout === */
        .detail-wrapper {
            padding-top: 100px; /* Space for fixed navbar */
            padding-bottom: 4rem;
        }

        /* === Breadcrumb === */
        .breadcrumb-wrapper {
            margin-bottom: 1.5rem;
        }

        .custom-breadcrumb {
            background: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            display: inline-flex;
            font-size: 0.9rem;
            border: 1px solid var(--glass-border);
        }

        .custom-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .custom-breadcrumb a:hover { color: var(--primary-color); }
        .custom-breadcrumb .active { color: var(--text-dark); font-weight: 600; cursor: default; }
        .breadcrumb-divider { margin: 0 10px; color: #cbd5e1; }

        /* === Glass Card (Detail) === */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        /* === Hero Image === */
        .hero-image-wrapper {
            height: 400px;
            position: relative;
            overflow: hidden;
        }

        .hero-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .glass-card:hover .hero-image {
            transform: scale(1.05);
        }

        .image-overlay-gradient {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(to top, rgba(0,0,0,0.6), transparent);
            pointer-events: none;
        }

        /* === Badges (Soft UI) === */
        .badge-float {
            position: absolute;
            bottom: 20px;
            left: 20px;
            z-index: 2;
            padding: 0.6rem 1.2rem;
            border-radius: 16px;
            font-size: 0.9rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            backdrop-filter: blur(8px);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .text-putra { color: var(--primary-color); }
        .text-putri { color: var(--secondary-color); }
        .text-campur { color: #10b981; }

        /* === Content === */
        .content-body { padding: 2.5rem; }

        .kost-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .kost-address {
            color: var(--text-muted);
            font-size: 1.05rem;
            display: flex;
            align-items: start;
            gap: 8px;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .description-text {
            color: var(--text-muted);
            line-height: 1.8;
            font-size: 1rem;
        }

        /* === Owner Box === */
        .owner-box {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            transition: all 0.3s;
        }

        .owner-box:hover {
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        }

        .owner-avatar {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #a8c0ff, #3f2b96);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            box-shadow: 0 5px 15px rgba(63, 43, 150, 0.2);
        }

        .btn-whatsapp {
            background: linear-gradient(135deg, #25D366, #128C7E);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 14px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(37, 211, 102, 0.4);
            color: white;
        }

        /* Animation */
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .hero-image-wrapper { height: 280px; }
            .content-body { padding: 1.5rem; }
            .kost-title { font-size: 1.6rem; }
            .owner-box { flex-direction: column; align-items: stretch; text-align: center; }
            .btn-whatsapp { justify-content: center; }
        }
    </style>
</head>
<body>

    {{-- Background Blobs --}}
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    {{-- Navbar (Konsisten dengan halaman lain) --}}
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand brand-text" href="{{ route('home') }}">
                <i class="fas fa-home"></i> KostApp
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    @auth
                        <a href="{{ route('home') }}" class="btn btn-outline-dark btn-sm rounded-pill px-4 fw-bold">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-4" style="background: var(--primary-color); border: none;">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

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

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>