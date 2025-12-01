@extends('layouts.app')

@section('title', 'Kelola Fasilitas - Kost App')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav class="mb-4" style="--bs-breadcrumb-divider: '/'; --bs-breadcrumb-margin-bottom: 0;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary text-decoration-none"><i class="fas fa-home me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.kos.index') }}" class="text-primary text-decoration-none">Manajemen Kos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.kos.show', $kos->kos_id) }}" class="text-primary text-decoration-none">{{ $kos->nama_kos }}</a></li>
            <li class="breadcrumb-item active">Kelola Fasilitas</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="mb-2"><i class="fas fa-star me-2" style="color: var(--primary-color);"></i>Kelola Fasilitas</h1>
        <p class="text-muted">{{ $kos->nama_kos }} - Tambah atau hapus fasilitas umum untuk properti Anda</p>
    </div>

    {{-- Fasilitas Aktif --}}
    <div class="glass-card mb-4">
        <h5 class="mb-4"><i class="fas fa-check me-2" style="color: #10b981;"></i> Fasilitas yang Aktif</h5>

        @if($fasilitasAktif->count() > 0)
            <div class="row">
                @foreach($fasilitasAktif as $fasilitas)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div style="background: white; border-radius: 12px; padding: 1.25rem; box-shadow: 0 2px 8px rgba(0,0,0,0.08); display: flex; justify-content: space-between; align-items: center; transition: all 0.3s;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 45px; height: 45px; background: linear-gradient(135deg, var(--primary-color), #5a52d5); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0" style="color: var(--text-dark); font-weight: 600;">{{ $fasilitas->nama_fasilitas }}</h6>
                                    <small class="text-muted"><i class="fas fa-tag me-1"></i> Umum</small>
                                </div>
                            </div>
                            <form method="POST" action="{{ route('pemilik.fasilitas.detach', [$kos->kos_id, $fasilitas->fasilitas_id]) }}" style="display: inline;" onsubmit="return confirm('Yakin hapus fasilitas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-inbox" style="font-size: 2rem; color: var(--primary-color); opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <p style="color: var(--text-muted);">Belum ada fasilitas yang ditambahkan.</p>
            </div>
        @endif
    </div>

    {{-- Tambah Fasilitas Baru --}}
    <div class="glass-card" style="background: rgba(59, 130, 246, 0.05); border: 2px dashed rgba(59, 130, 246, 0.3);">
        <h5 class="mb-4"><i class="fas fa-plus-circle me-2" style="color: #3B82F6;"></i> Tambah Fasilitas Baru</h5>

        @if($fasilitasAntrian->count() > 0)
            <form method="POST" action="{{ route('pemilik.fasilitas.attach', $kos->kos_id) }}">
                @csrf
                <div class="row mb-4">
                    @foreach($fasilitasAntrian as $fasilitas)
                        @if(!$fasilitasAktif->contains('fasilitas_id', $fasilitas->fasilitas_id))
                            <div class="col-md-6 col-lg-4 mb-3">
                                <label style="border: 2px solid rgba(108, 99, 255, 0.2); border-radius: 12px; padding: 1rem; cursor: pointer; transition: all 0.3s; display: block; text-align: center; text-decoration: none;">
                                    <input type="radio" name="fasilitas_id" value="{{ $fasilitas->fasilitas_id }}" required style="display: none;">
                                    <i class="fas fa-star" style="color: var(--primary-color); font-size: 1.5rem; margin-bottom: 0.5rem; display: block;"></i>
                                    <span style="display: block; font-weight: 500; color: var(--text-dark);">{{ $fasilitas->nama_fasilitas }}</span>
                                </label>
                            </div>
                        @endif
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary-gradient w-100">
                    <i class="fas fa-plus me-2"></i> Tambahkan Fasilitas
                </button>
            </form>
        @else
            <div style="text-align: center; padding: 2rem;">
                <i class="fas fa-check-circle" style="font-size: 2rem; color: #10b981; opacity: 0.5; margin-bottom: 1rem; display: block;"></i>
                <p style="color: var(--text-muted);">Semua fasilitas umum sudah ditambahkan!</p>
            </div>
        @endif
    </div>
</div>

<style>
    .breadcrumb {
        background: rgba(255, 255, 255, 0.5);
        border-radius: 12px;
        padding: 1rem;
        backdrop-filter: blur(10px);
    }

    label:hover {
        border-color: var(--primary-color) !important;
        background: rgba(108, 99, 255, 0.05) !important;
    }

    input[type="radio"]:checked + span,
    input[type="radio"]:checked ~ span {
        color: var(--primary-color);
        font-weight: 700;
    }
</style>
@endsection
