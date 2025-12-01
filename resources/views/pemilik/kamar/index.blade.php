@extends('layouts.app')

@section('title', 'Kelola Kamar - Kost App')

@section('content')
<div class="container py-5">
    {{-- Breadcrumb --}}
    <nav class="mb-4" style="--bs-breadcrumb-divider: '/'; --bs-breadcrumb-margin-bottom: 0;">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-primary text-decoration-none"><i class="fas fa-home me-1"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.kos.index') }}" class="text-primary text-decoration-none">Manajemen Kos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('pemilik.kos.show', $kos->kos_id) }}" class="text-primary text-decoration-none">{{ $kos->nama_kos }}</a></li>
            <li class="breadcrumb-item active">Kelola Kamar</li>
        </ol>
    </nav>

    {{-- Header --}}
    <div class="mb-4">
        <h1 class="mb-2"><i class="fas fa-door-open me-2" style="color: var(--primary-color);"></i>Kelola Kamar</h1>
        <p class="text-muted">{{ $kos->nama_kos }} - Tambah, edit, atau kelola kamar di properti Anda</p>
    </div>

    {{-- Button Tambah Kamar --}}
    <div class="mb-4">
        <a href="{{ route('pemilik.kamar.create', $kos->kos_id) }}" class="btn btn-primary-gradient">
            <i class="fas fa-plus-circle me-2"></i> Tambah Kamar Baru
        </a>
    </div>

    {{-- Tabel Kamar --}}
    <div class="glass-card">
        @if($kamars->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th><i class="fas fa-door-open me-2"></i> Nama Kamar</th>
                            <th><i class="fas fa-ruler me-2"></i> Ukuran</th>
                            <th><i class="fas fa-money-bill me-2"></i> Harga/Malam</th>
                            <th><i class="fas fa-check me-2"></i> Status</th>
                            <th class="text-center"><i class="fas fa-cog me-2"></i> Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kamars as $kamar)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div style="width: 50px; height: 50px; border-radius: 8px; overflow: hidden; background: #f0f0f0; display: flex; align-items: center; justify-content: center;">
                                            @if($kamar->fotoKamar && count($kamar->fotoKamar) > 0)
                                                <img src="{{ asset('storage/' . $kamar->fotoKamar[0]->url_foto) }}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <i class="fas fa-image" style="color: #999; font-size: 1.5rem;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div style="font-weight: 600;">{{ $kamar->nama_kamar }}</div>
                                            <small class="text-muted">{{ $kamar->fasilitas->count() }} fasilitas</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $kamar->ukuran_kamar ?? '-' }} m²</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: var(--primary-color);">
                                        Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $kamar->status_ketersediaan === 'tersedia' ? 'success' : 'danger' }}">
                                        {{ ucfirst($kamar->status_ketersediaan) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('pemilik.kamar.edit', [$kos->kos_id, $kamar->kamar_id]) }}" class="btn btn-sm btn-primary me-1" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('pemilik.kamar.destroy', [$kos->kos_id, $kamar->kamar_id]) }}" style="display:inline;" onsubmit="return confirm('Yakin hapus kamar ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
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
            <div style="text-align: center; padding: 3rem 1rem;">
                <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                <p style="font-size: 1.1rem; color: var(--text-muted);">
                    Belum ada kamar. <a href="{{ route('pemilik.kamar.create', $kos->kos_id) }}" style="color: var(--primary-color); font-weight: 600; text-decoration: none;">Tambah kamar pertama Anda</a>
                </p>
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
</style>
@endsection
