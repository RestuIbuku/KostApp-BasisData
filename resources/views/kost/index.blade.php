<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kost - Kost App</title>
    
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
            margin: 0;
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

        /* --- Navbar Glass --- */
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

        /* --- Layout --- */
        .dashboard-wrapper {
            padding-top: 100px;
            padding-bottom: 4rem;
        }

        /* --- Page Header --- */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 2rem;
            animation: fadeInDown 0.6s ease;
        }

        /* --- Summary Cards --- */
        .summary-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: var(--shadow);
            flex: 1; /* Agar lebar kartu rata */
            min-width: 150px;
        }

        .card-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .card-content h4 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .card-content p {
            margin: 0;
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .page-header h2 {
            color: var(--text-dark);
            font-weight: 700;
            margin: 0;
            font-size: 1.8rem;
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-top: 5px;
        }

        /* --- Glass Card for Table --- */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 1.5rem;
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        /* --- Custom Table Styling --- */
        .custom-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table thead th {
            background: rgba(255, 255, 255, 0.5);
            color: var(--text-muted);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .custom-table tbody tr {
            transition: all 0.2s ease;
        }

        .custom-table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.6);
        }

        .custom-table td {
            padding: 1.2rem 1rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0,0,0,0.03);
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        /* --- Image Wrapper --- */
        .table-img-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            position: relative;
        }

        .table-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .custom-table tbody tr:hover .table-img {
            transform: scale(1.1);
        }

        /* --- Badges --- */
        .badge-custom {
            padding: 0.5rem 1rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        /* Warna Badge */
        .badge-putra { background: rgba(108, 99, 255, 0.15); color: var(--primary-color); }
        .badge-putri { background: rgba(255, 101, 132, 0.15); color: var(--secondary-color); }
        .badge-campur { background: rgba(16, 185, 129, 0.15); color: #10b981; }

        /* --- Buttons --- */
        .btn-add-kost {
            background: linear-gradient(135deg, var(--primary-color), #5a52d5);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 16px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-kost:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            border: none;
            transition: all 0.2s;
            font-size: 0.9rem;
            color: white;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }

        .action-btn:hover { transform: translateY(-2px); box-shadow: 0 5px 12px rgba(0,0,0,0.15); color: white; }
        
        .btn-edit { background: linear-gradient(135deg, #f6d365, #fda085); }
        .btn-delete { background: linear-gradient(135deg, #ff9a9e, #fecfef); color: #d63031; } 
        
        /* Fix button icons */
        .btn-delete i { color: #c0392b; }
        .btn-edit i { color: #fff; }

        /* --- Empty State --- */
        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        /* Animations */
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }

        @media (max-width: 768px) {
            .page-header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .btn-add-kost { width: 100%; justify-content: center; }
            .summary-card { width: 100%; } /* Stack cards on mobile */
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
            <a class="navbar-brand brand-text" href="{{ route('home') }}">
                <i class="fas fa-home"></i> KostApp
            </a>
            
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    @auth
                        <div class="dropdown">
                            <button class="btn border-0 d-flex align-items-center gap-2 ps-0" type="button" data-bs-toggle="dropdown">
                                <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 35px; height: 35px; color: var(--primary-color); font-weight: bold;">
                                    {{ substr(Auth::user()->nama_lengkap, 0, 1) }}
                                </div>
                                <span class="fw-medium small" style="color: var(--text-dark);">{{ Str::limit(Auth::user()->nama_lengkap, 10) }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4 p-2 mt-2" style="background: rgba(255,255,255,0.95);">
                                <li><a class="dropdown-item rounded-3" href="#"><i class="fas fa-user me-2 text-primary"></i> Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item rounded-3 text-danger" href="{{ route('logout') }}" onclick="return confirm('Yakin ingin logout?')"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm rounded-pill px-4">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="dashboard-wrapper">
        <div class="container">

            {{-- HEADER & SUMMARY CARDS --}}
            <div class="page-header">
                <div style="flex: 1;">
                    <h2>Daftar Kost Saya</h2>
                    <p class="mb-4">Kelola properti kost Anda dengan mudah dan cepat</p>
                    
                    {{-- SUMMARY CARDS (Updated Area: Black Circle) --}}
                    <div class="d-flex flex-wrap gap-3">
                        {{-- Card 1: Total Kost --}}
                        <div class="summary-card">
                            <div class="card-icon" style="background: linear-gradient(135deg, #6C63FF, #5a52d5);">
                                <i class="fas fa-home"></i>
                            </div>
                            <div class="card-content">
                                <h4>{{ $total_kosts }}</h4>
                                <p>Total Kost</p>
                            </div>
                        </div>

                        {{-- Card 2: Total Kamar (NEW - Added Here) --}}
                        <div class="summary-card">
                            <div class="card-icon" style="background: linear-gradient(135deg, #FFC107, #FF9800);">
                                <i class="fas fa-bed"></i>
                            </div>
                            <div class="card-content">
                                {{-- Pastikan variable $total_seluruh_kamar dikirim dari controller --}}
                                <h4>{{ $total_kamar_total ?? 0 }}</h4>
                                <p>Total Kamar</p>
                            </div>
                        </div>

                        {{-- Card 3: Kamar Kosong --}}
                        <div class="summary-card">
                            <div class="card-icon" style="background: linear-gradient(135deg, #FF6584, #FF4081);">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div class="card-content">
                                <h4>{{ $total_kamar_kosong }}</h4>
                                <p>Kamar Kosong</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-3 mt-lg-0">
                    <a href="{{ route('kost.create') }}" class="btn-add-kost">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Kost</span>
                    </a>
                </div>
            </div>

            {{-- ALERT MESSAGES --}}
            @if(session('success'))
                <div class="alert alert-success shadow-sm border-0 rounded-4 mb-4 d-flex align-items-center" role="alert" style="background: #d1e7dd; color: #0f5132;">
                    <i class="fas fa-check-circle me-2 fs-5"></i> 
                    <div>{{ session('success') }}</div>
                    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- TABLE CARD (Updated Area: Red Cross - Removed Total Kamar Column) --}}
            <div class="glass-card">
                <div class="table-responsive">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th width="15%">Foto</th>
                                <th width="20%">Nama Kost</th>
                                <th width="25%">Alamat</th>
                                <th width="10%">Tipe</th>
                                <th width="10%">Total Kamar</th>
                                <th width="10%">Kamar Kosong</th>
                                <th width="15%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kosts as $kost)
                            <tr>
                                {{-- FOTO --}}
                                <td>
                                    <div class="table-img-wrapper">
                                        @if($kost->foto)
                                            @if(Str::startsWith($kost->foto, 'http'))
                                                <img src="{{ $kost->foto }}" class="table-img" alt="Foto Kost">
                                            @else
                                                <img src="{{ asset('storage/' . $kost->foto) }}" class="table-img" alt="Foto Kost">
                                            @endif
                                        @else
                                            <img src="https://placehold.co/100x100/6C63FF/FFF?text=Foto" class="table-img" alt="No Image">
                                        @endif
                                    </div>
                                </td>

                                {{-- NAMA KOST --}}
                                <td>
                                    <div class="fw-bold" style="font-size: 1rem; color: var(--text-dark);">{{ $kost->nama_kos }}</div>
                                    <small class="text-muted">ID: #{{ $kost->kos_id }}</small>
                                </td>

                                {{-- ALAMAT --}}
                                <td>
                                    <div class="d-flex gap-2">
                                        <i class="fas fa-map-marker-alt text-danger mt-1"></i>
                                        <span class="text-muted small" style="line-height: 1.5;">
                                            {{ Str::limit($kost->alamat, 45) }}
                                        </span>
                                    </div>
                                </td>

                                {{-- TIPE --}}
                                <td>
                                    @php
                                        $badgeClass = match($kost->tipe_kos) {
                                            'putra' => 'badge-putra',
                                            'putri' => 'badge-putri',
                                            'campur' => 'badge-campur',
                                            default => 'badge-putra'
                                        };
                                        $icon = match($kost->tipe_kos) {
                                            'putra' => 'fa-male',
                                            'putri' => 'fa-female',
                                            'campur' => 'fa-users',
                                            default => 'fa-home'
                                        };
                                    @endphp
                                    <span class="badge-custom {{ $badgeClass }}">
                                        <i class="fas {{ $icon }}"></i>
                                        {{ ucfirst($kost->tipe_kos) }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-bed" style="color: var(--primary-color);"></i>
                                        <span class="fw-bold" style="color: var(--text-dark);">{{ $kost->jumlah_kamar_total }}</span>
                                    </div>
                                </td>
                                {{-- JUMLAH KAMAR KOSONG --}}
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-door-open" style="color: #e17055;"></i>
                                        <span class="fw-bold" style="color: var(--text-dark);">{{ $kost->jumlah_kamar_kosong }}</span>
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <a href="{{ route('kost.edit', $kost->kos_id) }}" class="action-btn btn-edit" title="Edit Data">
                                        <i class="fas fa-pen"></i>
                                    </a>

                                    <form action="{{ route('kost.destroy', $kost->kos_id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn btn-delete"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus kost ini? Data tidak bisa dikembalikan.')"
                                                title="Hapus Permanen">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <div class="empty-state">
                                        <div class="mb-3">
                                            <div style="width: 80px; height: 80px; background: rgba(108, 99, 255, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                                                <i class="fas fa-folder-open fa-2x" style="color: var(--primary-color);"></i>
                                            </div>
                                        </div>
                                        <h5 class="fw-bold" style="color: var(--text-dark);">Belum ada data kost</h5>
                                        <p class="text-muted small mb-4">Mulai sewakan properti Anda dengan menambah data kost baru.</p>
                                        <a href="{{ route('kost.create') }}" class="btn-add-kost">
                                            <i class="fas fa-plus me-1"></i> Tambah Sekarang
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- END CARD --}}

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>