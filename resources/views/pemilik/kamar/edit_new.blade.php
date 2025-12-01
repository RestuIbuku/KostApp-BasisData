@extends('layouts.app')

@section('title', 'Edit Kamar - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('pemilik.kamar.index', $kos->kos_id) }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="glass-card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Kamar</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <h5>Ada Error!</h5>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('pemilik.kamar.update', [$kos->kos_id, $kamar->kamar_id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Kamar --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_kamar" class="form-label"><i class="fas fa-door-open text-primary"></i> Nama Kamar</label>
                                <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror" id="nama_kamar" name="nama_kamar" value="{{ old('nama_kamar', $kamar->nama_kamar) }}" required>
                                @error('nama_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Harga per Malam --}}
                            <div class="col-md-6 mb-3">
                                <label for="harga_per_malam" class="form-label"><i class="fas fa-money-bill-alt text-success"></i> Harga per Malam</label>
                                <input type="number" step="0.01" class="form-control @error('harga_per_malam') is-invalid @enderror" id="harga_per_malam" name="harga_per_malam" value="{{ old('harga_per_malam', $kamar->harga_per_malam) }}" required>
                                @error('harga_per_malam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Ukuran Kamar --}}
                            <div class="col-md-6 mb-3">
                                <label for="ukuran_kamar" class="form-label"><i class="fas fa-expand text-warning"></i> Ukuran Kamar</label>
                                <input type="text" class="form-control @error('ukuran_kamar') is-invalid @enderror" id="ukuran_kamar" name="ukuran_kamar" placeholder="Contoh: 3x4 m" value="{{ old('ukuran_kamar', $kamar->ukuran_kamar) }}">
                                @error('ukuran_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Status Ketersediaan --}}
                            <div class="col-md-6 mb-3">
                                <label for="status_ketersediaan" class="form-label"><i class="fas fa-check-circle text-info"></i> Status</label>
                                <select class="form-select @error('status_ketersediaan') is-invalid @enderror" id="status_ketersediaan" name="status_ketersediaan" required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="tersedia" {{ old('status_ketersediaan', $kamar->status_ketersediaan) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                    <option value="penuh" {{ old('status_ketersediaan', $kamar->status_ketersediaan) == 'penuh' ? 'selected' : '' }}>Penuh</option>
                                </select>
                                @error('status_ketersediaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Fasilitas Kamar --}}
                            @if($fasilitas->count() > 0)
                            <div class="col-12 mb-3">
                                <label class="form-label"><i class="fas fa-list text-primary"></i> Fasilitas Kamar</label>
                                <div class="row">
                                    @foreach($fasilitas as $fas)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="fas{{ $fas->fasilitas_id }}" name="fasilitas[]" value="{{ $fas->fasilitas_id }}" {{ in_array($fas->fasilitas_id, $selected_fasilitas ?? []) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="fas{{ $fas->fasilitas_id }}">
                                                {{ $fas->nama_fasilitas }}
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save"></i> Simpan Perubahan
                            </button>
                            <a href="{{ route('pemilik.kamar.index', $kos->kos_id) }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Section untuk Upload Foto --}}
            <div class="glass-card mt-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-image"></i> Kelola Foto Kamar</h5>
                </div>

                <div class="card-body">
                    {{-- Upload Form --}}
                    <form action="{{ route('pemilik.foto-kamar.store', [$kos->kos_id, $kamar->kamar_id]) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                        @csrf

                        <div class="mb-3">
                            <label for="foto" class="form-label"><i class="fas fa-upload"></i> Upload Foto Baru</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*" required>
                            @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_foto" class="form-label"><i class="fas fa-align-left"></i> Deskripsi (Opsional)</label>
                            <input type="text" class="form-control" id="deskripsi_foto" name="deskripsi_foto" placeholder="Contoh: Tampak dari depan" maxlength="255">
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-upload"></i> Upload Foto
                        </button>
                    </form>

                    {{-- Daftar Foto --}}
                    <hr>
                    <h6 class="mb-3">Foto Kamar yang Ada</h6>

                    @if($kamar->fotoKamar && $kamar->fotoKamar->count() > 0)
                        <div class="row g-3">
                            @foreach($kamar->fotoKamar as $foto)
                            <div class="col-md-4">
                                <div class="card">
                                    @if(Str::startsWith($foto->url_foto, 'http'))
                                        <img src="{{ $foto->url_foto }}" class="card-img-top" alt="Foto Kamar" style="height: 200px; object-fit: cover;">
                                    @else
                                        <img src="{{ asset('storage/' . $foto->url_foto) }}" class="card-img-top" alt="Foto Kamar" style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <p class="card-text text-muted" style="font-size: 0.85rem;">{{ $foto->deskripsi_foto ?? 'Tidak ada deskripsi' }}</p>
                                        <form action="{{ route('pemilik.foto-kamar.destroy', $foto->foto_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus foto ini?')">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Belum ada foto untuk kamar ini. Silakan upload foto kamar Anda.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
