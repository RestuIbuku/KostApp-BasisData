<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar - Kost App</title>
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
        }

        .form-control, .form-select {
            border: 2px solid var(--glass-border);
            border-radius: 12px;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(108, 99, 255, 0.25);
            outline: none;
        }

        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 2rem;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            color: white;
            border-radius: 12px;
            font-weight: 600;
            padding: 0.8rem 2rem;
            transition: all 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .checkbox-group {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
        }

        .checkbox-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            border: 2px solid var(--glass-border);
            cursor: pointer;
            transition: all 0.3s;
        }

        .checkbox-item:hover {
            border-color: var(--primary-color);
            background: rgba(108, 99, 255, 0.05);
        }

        .checkbox-item input {
            cursor: pointer;
        }

        h2 {
            color: white;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }

        .form-label-custom {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-title {
            font-weight: 700;
            color: var(--text-dark);
            margin-top: 2rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--glass-border);
        }

        .foto-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .foto-item {
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .foto-item img {
            width: 100%;
            height: 100px;
            object-fit: cover;
        }

        .foto-delete {
            position: absolute;
            top: 0;
            right: 0;
            background: rgba(239, 68, 68, 0.9);
            color: white;
            border: none;
            padding: 0.4rem 0.6rem;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .foto-item:hover .foto-delete {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2><i class="fas fa-edit me-2"></i> Edit Kamar</h2>

                {{-- Alert Errors --}}
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show glass-card" role="alert">
                    <h5 class="alert-heading"><i class="fas fa-exclamation-circle me-2"></i> Ada Kesalahan</h5>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="glass-card">
                    {{-- Form Edit Kamar --}}
                    <form method="POST" action="{{ route('pemilik.kamar.update', [$kos->kos_id, $kamar->kamar_id]) }}">
                        @csrf
                        @method('PUT')

                        {{-- Informasi Kos --}}
                        <div class="alert alert-info glass-card mb-4" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <i class="fas fa-building" style="font-size: 1.5rem; color: #3B82F6;"></i>
                                <div>
                                    <strong style="color: #1F2937;">Kos:</strong><br>
                                    <span style="color: #6B7280;">{{ $kos->nama_kos }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Detail Kamar --}}
                        <div class="mb-4">
                            <label class="form-label-custom"><i class="fas fa-door-open"></i> Nama Kamar</label>
                            <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror"
                                   name="nama_kamar" placeholder="Contoh: Kamar A, Kamar VIP 1" required
                                   value="{{ old('nama_kamar', $kamar->nama_kamar) }}">
                            @error('nama_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Harga & Ukuran --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom"><i class="fas fa-money-bill"></i> Harga per Malam (Rp)</label>
                                <input type="number" class="form-control @error('harga_per_malam') is-invalid @enderror"
                                       name="harga_per_malam" placeholder="Contoh: 150000" required min="1000"
                                       value="{{ old('harga_per_malam', $kamar->harga_per_malam) }}">
                                @error('harga_per_malam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom"><i class="fas fa-ruler-combined"></i> Ukuran Kamar</label>
                                <input type="text" class="form-control @error('ukuran_kamar') is-invalid @enderror"
                                       name="ukuran_kamar" placeholder="Contoh: 3x4 m atau 12 m²"
                                       value="{{ old('ukuran_kamar', $kamar->ukuran_kamar) }}">
                                @error('ukuran_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Status Ketersediaan --}}
                        <div class="mb-4">
                            <label class="form-label-custom"><i class="fas fa-check-circle"></i> Status Ketersediaan</label>
                            <select class="form-select @error('status_ketersediaan') is-invalid @enderror"
                                    name="status_ketersediaan" required>
                                <option value="tersedia" {{ $kamar->status_ketersediaan == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                <option value="penuh" {{ $kamar->status_ketersediaan == 'penuh' ? 'selected' : '' }}>Penuh</option>
                            </select>
                            @error('status_ketersediaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Fasilitas Kamar --}}
                        <div class="mb-4">
                            <label class="form-label-custom"><i class="fas fa-star"></i> Fasilitas Kamar</label>
                            <div class="checkbox-group">
                                @foreach($fasilitas as $fas)
                                <label class="checkbox-item">
                                    <input type="checkbox" name="fasilitas[]" value="{{ $fas->fasilitas_id }}"
                                           {{ in_array($fas->fasilitas_id, $selected_fasilitas) ? 'checked' : '' }}>
                                    <span>{{ $fas->nama_fasilitas }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex gap-2 justify-content-end">
                            <a href="{{ route('pemilik.kamar.index', $kos->kos_id) }}" class="btn btn-secondary" style="border-radius: 12px; padding: 0.8rem 1.5rem;">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-submit">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>

                    {{-- Section Foto Kamar --}}
                    <div class="section-title">
                        <i class="fas fa-images me-2"></i> Kelola Foto Kamar
                    </div>

                    {{-- Upload Foto Form --}}
                    <form method="POST" action="{{ route('pemilik.foto.store', [$kos->kos_id, $kamar->kamar_id]) }}" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label-custom"><i class="fas fa-image"></i> Upload Foto</label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                       name="foto" accept="image/*" required>
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label-custom">&nbsp;</label>
                                <button type="submit" class="btn btn-submit w-100">
                                    <i class="fas fa-upload me-2"></i> Upload
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label-custom"><i class="fas fa-align-left"></i> Deskripsi (Opsional)</label>
                            <input type="text" class="form-control"
                                   name="deskripsi_foto" placeholder="Contoh: Pandangan dari depan, Kamar mandi, dll">
                        </div>
                    </form>

                    {{-- Daftar Foto --}}
                    @if($kamar->fotoKamar && count($kamar->fotoKamar) > 0)
                    <div>
                        <h6 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Foto yang Tersimpan ({{ count($kamar->fotoKamar) }})</h6>
                        <div class="foto-grid">
                            @foreach($kamar->fotoKamar as $foto)
                            <div class="foto-item">
                                <img src="{{ asset('storage/' . $foto->url_foto) }}" alt="Foto">
                                <form method="POST" action="{{ route('pemilik.foto.destroy', $foto->foto_id) }}" style="display: inline;" onsubmit="return confirm('Hapus foto ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="foto-delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div style="text-align: center; padding: 2rem; color: var(--text-muted); background: rgba(0,0,0,0.02); border-radius: 12px;">
                        <i class="fas fa-image" style="font-size: 2rem; opacity: 0.3; margin-bottom: 0.5rem; display: block;"></i>
                        <p>Belum ada foto untuk kamar ini</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
