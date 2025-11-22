@extends('layouts.app')

@section('title', 'Profil - Kost App')

@push('styles')
<style>
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
@endpush

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">

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
                    <a href="{{ route('pencari.index') }}" class="btn btn-outline-custom">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Jelajah
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
@endsection
