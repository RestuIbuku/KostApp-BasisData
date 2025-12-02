<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Kost App</title>

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

        /* --- Profile Container --- */
        .profile-wrapper {
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

        /* --- Avatar --- */
        .avatar-large {
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            border: 4px solid rgba(255,255,255,0.5);
            margin: 0 auto;
        }

        /* --- Form Styles --- */
        .form-control {
            border: 2px solid rgba(108, 99, 255, 0.1);
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        /* --- Buttons --- */
        .btn-primary-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            color: white;
            border: none;
            padding: 12px 25px;
            border-radius: 16px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(108, 99, 255, 0.3);
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
        }

        .btn-outline-custom:hover {
            background: var(--primary-color);
            color: white;
        }

        /* --- Animation --- */
        .animate-fade-up {
            animation: fadeInUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
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
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded-3 text-danger w-100 text-start" style="border: none; background: none; padding: 0.5rem 1rem;">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
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
    <div class="profile-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    {{-- Alert --}}
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 animate-fade-up" style="background: #d1e7dd; color: #0f5132;">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    {{-- Profile Card --}}
                    <div class="glass-card animate-fade-up">
                        <div class="text-center mb-4">
                            <div class="avatar-large mb-3">
                                <i class="fas fa-user"></i>
                            </div>
                            <h3 class="fw-bold text-dark">{{ Auth::user()->nama_lengkap }}</h3>
                            <p class="text-muted mb-0">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>

                        <hr class="my-4" style="opacity: 0.1;">

                        <h5 class="fw-bold text-dark mb-4"><i class="fas fa-edit me-2 text-primary"></i>Edit Profil</h5>

                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', Auth::user()->nama_lengkap) }}" required>
                                    @error('nama_lengkap')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="no_hp" class="form-label">Nomor HP</label>
                                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', Auth::user()->no_hp) }}" required>
                                    @error('no_hp')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" class="form-control" id="role" value="{{ ucfirst(Auth::user()->role) }}" readonly>
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn btn-primary-gradient">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-custom">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
                                </a>
                            </div>
                        </form>

                        <hr class="my-5" style="opacity: 0.1;">

                        <h5 class="fw-bold text-dark mb-4"><i class="fas fa-lock me-2 text-primary"></i>Ganti Password</h5>

                        <form action="{{ route('profile.updatePassword') }}" method="POST">
                            @csrf

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="current_password" class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    @error('password_confirmation')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex gap-3 mt-4">
                                <button type="submit" class="btn btn-primary-gradient">
                                    <i class="fas fa-key me-2"></i>Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Ensure Bootstrap dropdown is initialized
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            dropdownElements.forEach(element => {
                new bootstrap.Dropdown(element);
            });
        });
    </script>
</body>
</html>
