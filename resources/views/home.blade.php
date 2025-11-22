<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kost App</title>
    
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
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(255, 255, 255, 0.5);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
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

        /* --- Dashboard Container --- */
        .dashboard-wrapper {
            padding-top: 100px; /* Compensate fixed navbar */
            padding-bottom: 4rem;
        }

        /* --- Glass Cards (Global Style) --- */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 2rem;
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(108, 99, 255, 0.15);
        }

        /* --- Welcome Section --- */
        .welcome-section {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .avatar-circle {
            width: 90px;
            height: 90px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            border: 4px solid rgba(255,255,255,0.5);
        }

        .badge-role {
            background: rgba(108, 99, 255, 0.1);
            color: var(--primary-color);
            padding: 6px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            border: 1px solid rgba(108, 99, 255, 0.2);
        }

        /* --- Stat Cards --- */
        .stat-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
        }

        /* --- Buttons & Links --- */
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary-color), #5a52d5);
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 10px 25px;
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }

        /* Quick Links Grid */
        .quick-link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 20px;
            padding: 1.5rem;
            text-decoration: none;
            color: var(--text-dark);
            transition: all 0.3s;
            border: 1px solid transparent;
        }

        .quick-link-item i {
            font-size: 2rem;
            margin-bottom: 10px;
            background: -webkit-linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .quick-link-item:hover {
            background: white;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: var(--primary-color);
        }

        /* Animation Utility */
        .animate-fade-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Delays */
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Responsive */
        @media (max-width: 768px) {
            .welcome-section { flex-direction: column; text-align: center; }
            .glass-card { padding: 1.5rem; }
        }
    </style>
</head>
<body>

    {{-- Background Blobs --}}
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-glass fixed-top">
        <div class="container">
            <a class="navbar-brand brand-text" href="#">
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
    <div class="dashboard-wrapper">
        <div class="container">
            
            {{-- Alert --}}
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate-fade-up" style="background: #d1e7dd; color: #0f5132;">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Welcome Card --}}
            <div class="glass-card mb-4 animate-fade-up">
                <div class="welcome-section">
                    <div class="avatar-circle">
                        <i class="fas fa-smile"></i>
                    </div>
                    <div>
                        <h2 class="fw-bold m-0" style="color: var(--text-dark);">Halo, {{ Auth::user()->nama_lengkap }}! 👋</h2>
                        <p class="mb-2 text-muted">Selamat datang kembali, semoga harimu menyenangkan.</p>
                        <span class="badge-role">
                            <i class="fas fa-shield-alt me-1"></i> {{ ucfirst(Auth::user()->role) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Stats Row (UPDATED: 3 Kolom) --}}
            <div class="row g-4 mb-4">
                {{-- Stat 1: Total Kost --}}
                <div class="col-md-4 animate-fade-up delay-1">
                    <div class="glass-card stat-card">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Total Kost</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $total_kosts }}</h3>
                            <span class="text-success small fw-bold"><i class="fas fa-arrow-up"></i> Unit Aktif</span>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(108, 99, 255, 0.1); color: var(--primary-color);">
                            <i class="fas fa-building"></i>
                        </div>
                    </div>
                </div>

                {{-- Stat 2: Total Kamar (NEW) --}}
                <div class="col-md-4 animate-fade-up delay-2">
                    <div class="glass-card stat-card">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Total Kamar</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $total_kamar ?? 0 }}</h3>
                            <span class="text-warning small fw-bold"><i class="fas fa-door-open"></i> Seluruh Unit</span>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(255, 193, 7, 0.1); color: #ffc107;">
                            <i class="fas fa-bed"></i>
                        </div>
                    </div>
                </div>

                {{-- Stat 3: Kamar Kosong --}}
                <div class="col-md-4 animate-fade-up delay-3">
                    <div class="glass-card stat-card">
                        <div>
                            <p class="text-muted mb-1 small fw-bold text-uppercase">Kamar Kosong</p>
                            <h3 class="fw-bold text-dark mb-0">{{ $total_kamar_kosong }}</h3>
                            <span class="text-danger small fw-bold">Tersedia</span>
                        </div>
                        <div class="stat-icon-wrapper" style="background: rgba(255, 101, 132, 0.1); color: var(--secondary-color);">
                            <i class="fas fa-key"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Area (Owner Only) --}}
            @if(Auth::user()->role == 'pemilik')
            <div class="row g-4 animate-fade-up delay-3">
                <div class="col-lg-8">
                    <div class="glass-card">
                        <h5 class="fw-bold text-dark mb-4"><i class="fas fa-tasks me-2 text-primary"></i>Kelola Kost</h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <a href="{{ route('kost.index') }}" class="btn-primary-gradient w-100 justify-content-center py-3">
                                    <i class="fas fa-database"></i> Data Kost Saya
                                </a>
                            </div>
                            <div class="col-md-6">
                                <a href="{{ route('kost.create') }}" class="btn-outline-custom w-100 justify-content-center py-3">
                                    <i class="fas fa-plus-circle"></i> Tambah Unit Baru
                                </a>
                            </div>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <h6 class="fw-bold text-muted mb-3 small text-uppercase">Menu Pintas</h6>
                        <div class="row row-cols-2 row-cols-md-4 g-3">
                            <a href="#" class="quick-link-item">
                                <i class="fas fa-wallet"></i>
                                <span class="small fw-bold">Keuangan</span>
                            </a>
                            <a href="#" class="quick-link-item">
                                <i class="fas fa-bell"></i>
                                <span class="small fw-bold">Notifikasi</span>
                            </a>
                            <a href="#" class="quick-link-item">
                                <i class="fas fa-chart-pie"></i>
                                <span class="small fw-bold">Statistik</span>
                            </a>
                            <a href="#" class="quick-link-item">
                                <i class="fas fa-cog"></i>
                                <span class="small fw-bold">Pengaturan</span>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Side Widget --}}
                <div class="col-lg-4">
                    <div class="glass-card" style="background: linear-gradient(135deg, #6C63FF, #8f89ff); color: white; border: none;">
                        <div class="text-center py-4">
                            <i class="fas fa-rocket fa-3x mb-3" style="color: rgba(255,255,255,0.8);"></i>
                            <h5 class="fw-bold">Tingkatkan Hunian!</h5>
                            <p class="small opacity-75 mb-4">Gunakan fitur promosi premium agar kost Anda lebih sering muncul di pencarian.</p>
                            <button class="btn btn-light text-primary rounded-pill px-4 fw-bold shadow-sm">Pelajari</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>