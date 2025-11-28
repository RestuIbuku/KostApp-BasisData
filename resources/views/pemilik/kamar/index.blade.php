<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Kamar - Kost App</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6C63FF;
            --primary-hover: #5a52d5;
            --secondary-color: #FF6584;
            --text-dark: #2D3436;
            --text-muted: #636e72;
            --glass-bg: rgba(255, 255, 255, 0.7);
            --glass-border: rgba(108, 99, 255, 0.2);
            --shadow: 0 8px 32px rgba(31, 38, 135, 0.15);
        }

        * { font-family: 'Poppins', sans-serif; }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -10%;
            width: 500px;
            height: 500px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            filter: blur(40px);
            z-index: -1;
        }

        .navbar-glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--glass-border);
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            color: white;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.6rem 1.5rem;
            transition: all 0.3s;
        }

        .btn-primary-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .table-img-wrapper {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .table-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .kamar-table {
            margin-top: 1.5rem;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            margin: 0 2px;
            text-decoration: none;
            color: white;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-edit {
            background: linear-gradient(135deg, #3B82F6, #2563EB);
        }

        .btn-delete {
            background: linear-gradient(135deg, #EF4444, #DC2626);
        }

        .btn-photos {
            background: linear-gradient(135deg, #10B981, #059669);
        }

        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: white;
        }

        .badge {
            border-radius: 50px;
            padding: 0.4rem 0.8rem;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
        }

        .breadcrumb-custom {
            background: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-custom a, .breadcrumb-custom span {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
        }

        .breadcrumb-custom a:hover {
            color: white;
        }

        .breadcrumb-custom .active {
            color: white;
            font-weight: 600;
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-glass">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">
                <i class="fas fa-home" style="color: var(--primary-color);"></i> KostApp
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="ms-auto">
                    @auth
                    <a href="{{ route('logout') }}" class="btn btn-danger btn-sm rounded-pill" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;"></form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        {{-- Breadcrumb --}}
        <nav class="breadcrumb-custom mb-4">
            <a href="{{ route('home') }}"><i class="fas fa-home me-1"></i> Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('kost.show', $kos->kos_id) }}">{{ $kos->nama_kos }}</a>
            <span class="mx-2">/</span>
            <span class="active">Kelola Kamar</span>
        </nav>

        {{-- Header --}}
        <div class="page-header">
            <h2><i class="fas fa-door-open me-2"></i> Kelola Kamar - {{ $kos->nama_kos }}</h2>
            <p>Tambah, edit, atau kelola kamar di properti Anda</p>
        </div>

        {{-- Alert --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show glass-card" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        {{-- Button Tambah Kamar --}}
        <div class="mb-4">
            <a href="{{ route('pemilik.kamar.create', $kos->kos_id) }}" class="btn btn-primary-gradient">
                <i class="fas fa-plus-circle me-2"></i> Tambah Kamar Baru
            </a>
        </div>

        {{-- Tabel Kamar --}}
        <div class="glass-card kamar-table">
            @if($kamars->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr style="background: rgba(108, 99, 255, 0.05); border-bottom: 2px solid var(--glass-border);">
                            <th style="color: var(--text-dark); font-weight: 600;"><i class="fas fa-door-open me-2"></i> Nama Kamar</th>
                            <th style="color: var(--text-dark); font-weight: 600;"><i class="fas fa-ruler me-2"></i> Ukuran</th>
                            <th style="color: var(--text-dark); font-weight: 600;"><i class="fas fa-money-bill me-2"></i> Harga/Malam</th>
                            <th style="color: var(--text-dark); font-weight: 600;"><i class="fas fa-check me-2"></i> Status</th>
                            <th style="color: var(--text-dark); font-weight: 600;" class="text-center"><i class="fas fa-cog me-2"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamars as $kamar)
                        <tr style="border-bottom: 1px solid var(--glass-border);">
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="table-img-wrapper">
                                        @if($kamar->fotoKamar && count($kamar->fotoKamar) > 0)
                                            <img src="{{ asset('storage/' . $kamar->fotoKamar[0]->url_foto) }}" alt="Foto">
                                        @else
                                            <i class="fas fa-image" style="color: #999; font-size: 1.5rem;"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; color: var(--text-dark);">{{ $kamar->nama_kamar }}</div>
                                        <small class="text-muted">{{ $kamar->fasilitas->count() }} fasilitas</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="color: var(--text-muted);">{{ $kamar->ukuran_kamar ?? '-' }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: var(--primary-color);">
                                    Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $kamar->status_ketersediaan === 'tersedia' ? 'bg-success' : 'bg-danger' }}">
                                    {{ ucfirst($kamar->status_ketersediaan) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('pemilik.kamar.edit', [$kos->kos_id, $kamar->kamar_id]) }}" class="action-btn btn-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('pemilik.kamar.index', $kos->kos_id) }}" class="action-btn btn-photos" title="Kelola Foto">
                                    <i class="fas fa-image"></i>
                                </a>
                                <form method="POST" action="{{ route('pemilik.kamar.destroy', [$kos->kos_id, $kamar->kamar_id]) }}" style="display:inline;" onsubmit="return confirm('Yakin hapus kamar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn btn-delete" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($kamars->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $kamars->links('pagination::bootstrap-5') }}
            </div>
            @endif
            @else
            <div style="text-align: center; padding: 3rem 1rem; color: var(--text-muted);">
                <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <p style="font-size: 1.1rem;">Belum ada kamar. <a href="{{ route('pemilik.kamar.create', $kos->kos_id) }}" style="color: var(--primary-color); font-weight: 600;">Tambah kamar pertama Anda</a></p>
            </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
