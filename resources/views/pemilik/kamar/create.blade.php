<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kamar - Kost App</title>
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
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2><i class="fas fa-plus-circle me-2"></i> Tambah Kamar Baru</h2>

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
                    <form method="POST" action="{{ route('pemilik.kamar.store', $kos->kos_id) }}">
                        @csrf

                        {{-- Informasi Kos --}}
                        <div class="alert alert-info glass-card mb-4" style="background: rgba(59, 130, 246, 0.1); border-color: rgba(59, 130, 246, 0.3);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <i class="fas fa-building" style="font-size: 1.5rem; color: #3B82F6;"></i>
                                <div>
                                    <strong style="color: #1F2937;">Menambah kamar untuk:</strong><br>
                                    <span style="color: #6B7280;">{{ $kos->nama_kos }} - {{ $kos->alamat }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Nama Kamar --}}
                        <div class="mb-4">
                            <label class="form-label-custom"><i class="fas fa-door-open"></i> Nama Kamar</label>
                            <input type="text" class="form-control @error('nama_kamar') is-invalid @enderror"
                                   name="nama_kamar" placeholder="Contoh: Kamar A, Kamar VIP 1" required
                                   value="{{ old('nama_kamar') }}">
                            @error('nama_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Harga & Ukuran --}}
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom"><i class="fas fa-money-bill"></i> Harga per Malam (Rp)</label>
                                <input type="number" class="form-control @error('harga_per_malam') is-invalid @enderror"
                                       name="harga_per_malam" placeholder="Contoh: 150000" required min="1000"
                                       value="{{ old('harga_per_malam') }}">
                                @error('harga_per_malam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label-custom"><i class="fas fa-ruler-combined"></i> Ukuran Kamar</label>
                                <input type="text" class="form-control @error('ukuran_kamar') is-invalid @enderror"
                                       name="ukuran_kamar" placeholder="Contoh: 3x4 m atau 12 m²"
                                       value="{{ old('ukuran_kamar') }}">
                                @error('ukuran_kamar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Status Ketersediaan --}}
                        <div class="mb-4">
                            <label class="form-label-custom"><i class="fas fa-check-circle"></i> Status Ketersediaan</label>
                            <select class="form-select @error('status_ketersediaan') is-invalid @enderror"
                                    name="status_ketersediaan" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="tersedia" {{ old('status_ketersediaan') == 'tersedia' ? 'selected' : '' }}>
                                    <i class="fas fa-check text-success"></i> Tersedia
                                </option>
                                <option value="penuh" {{ old('status_ketersediaan') == 'penuh' ? 'selected' : '' }}>
                                    <i class="fas fa-times text-danger"></i> Penuh
                                </option>
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
                                           {{ in_array($fas->fasilitas_id, old('fasilitas', [])) ? 'checked' : '' }}>
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
                                <i class="fas fa-save me-2"></i> Simpan Kamar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
