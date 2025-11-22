<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kost - Kost App</title>

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
            --input-bg: rgba(255, 255, 255, 0.9);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            position: relative;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* === Animated Background Blobs === */
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

        /* === Layout === */
        .page-wrapper {
            padding: 3rem 0 5rem;
        }

        /* === Glass Card Styles === */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            overflow: hidden;
            animation: fadeInUp 0.6s ease;
        }

        .form-header {
            background: rgba(255, 255, 255, 0.4);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .header-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #FFA502, #ffc107); /* Warna Orange untuk Edit */
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 8px 15px rgba(255, 165, 2, 0.3);
        }

        /* === Form Inputs === */
        .form-label-custom {
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-control, .form-select {
            background-color: var(--input-bg);
            border: 1px solid transparent;
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.95rem;
            transition: all 0.3s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }

        .form-control:focus, .form-select:focus {
            background-color: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.15);
        }

        /* === Custom File Upload === */
        .file-upload-wrapper {
            position: relative;
            height: 150px;
            border: 2px dashed rgba(108, 99, 255, 0.3);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
            cursor: pointer;
        }

        .file-upload-wrapper:hover {
            border-color: var(--primary-color);
            background: rgba(255, 255, 255, 0.8);
        }

        .file-upload-input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            top: 0; left: 0;
        }

        .upload-icon {
            font-size: 2.5rem;
            color: #a4b0be;
            margin-bottom: 10px;
            transition: color 0.3s;
        }

        .file-upload-wrapper:hover .upload-icon {
            color: var(--primary-color);
        }

        /* === Buttons === */
        .btn-back {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
            padding: 8px 16px;
            border-radius: 12px;
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.5);
            color: var(--primary-color);
            transform: translateX(-3px);
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color), #5a52d5);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
            color: white;
        }

        .btn-cancel {
            background: white;
            color: var(--text-muted);
            font-weight: 600;
            border: 1px solid #e2e8f0;
            padding: 0.8rem 2rem;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .btn-cancel:hover {
            background: #f1f5f9;
            color: var(--text-dark);
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    {{-- Background Blobs --}}
    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="page-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    
                    {{-- TOMBOL KEMBALI --}}
                    <div class="mb-3">
                        <a href="{{ route('kost.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>

                    <div class="glass-card">
                        {{-- HEADER CARD --}}
                        <div class="form-header">
                            <div class="header-icon">
                                <i class="fas fa-edit"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-dark);">Edit Data Kost</h4>
                                <small style="color: var(--text-muted);">Perbarui informasi kost Anda di bawah ini</small>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('kost.update', $kost->kos_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div class="row">
                                    {{-- KOLOM KIRI --}}
                                    <div class="col-md-6 mb-3">
                                        {{-- NAMA KOST --}}
                                        <div class="mb-3">
                                            <label class="form-label-custom"><i class="fas fa-heading" style="color: var(--primary-color);"></i> Nama Kost</label>
                                            <input type="text" class="form-control @error('nama_kos') is-invalid @enderror"
                                                   name="nama_kos" value="{{ old('nama_kos', $kost->nama_kos) }}" required>
                                            @error('nama_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        {{-- TIPE KOST --}}
                                        <div class="mb-3">
                                            <label class="form-label-custom"><i class="fas fa-venus-mars" style="color: var(--secondary-color);"></i> Tipe Kost</label>
                                            <select class="form-select @error('tipe_kos') is-invalid @enderror" name="tipe_kos" required>
                                                <option value="">Pilih Tipe...</option>
                                                <option value="putra" {{ old('tipe_kos', $kost->tipe_kos) == 'putra' ? 'selected' : '' }}>👨 Putra</option>
                                                <option value="putri" {{ old('tipe_kos', $kost->tipe_kos) == 'putri' ? 'selected' : '' }}>👩 Putri</option>
                                                <option value="campur" {{ old('tipe_kos', $kost->tipe_kos) == 'campur' ? 'selected' : '' }}>👥 Campur</option>
                                            </select>
                                            @error('tipe_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    {{-- KOLOM KANAN (FOTO UPLOAD) --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom"><i class="fas fa-image" style="color: #00b894;"></i> Foto Kost</label>
                                        
                                        {{-- Preview Foto Lama (Jika Ada) --}}
                                        @if($kost->foto)
                                            <div class="mb-2 d-flex align-items-center gap-2">
                                                <span class="badge bg-light text-dark border">Foto Saat Ini</span>
                                                <small class="text-muted text-truncate" style="max-width: 150px;">{{ $kost->foto }}</small>
                                            </div>
                                        @endif

                                        <div class="file-upload-wrapper">
                                            <input type="file" class="file-upload-input @error('foto') is-invalid @enderror" name="foto" accept="image/*" onchange="previewFile(this)">
                                            <div class="text-center p-3">
                                                <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                <p class="mb-0 fw-semibold text-muted" id="fileName" style="font-size: 0.9rem;">Ganti Foto (Opsional)</p>
                                                <small class="text-muted" style="font-size: 0.75rem;">Max: 5MB (JPG/PNG)</small>
                                            </div>
                                        </div>
                                        @error('foto') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <hr class="my-2" style="border-color: rgba(0,0,0,0.1);">

                                {{-- ALAMAT --}}
                                <div class="mb-3">
                                    <label class="form-label-custom"><i class="fas fa-map-marker-alt text-danger"></i> Alamat Lengkap</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                              name="alamat" rows="2" required>{{ old('alamat', $kost->alamat) }}</textarea>
                                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- DESKRIPSI --}}
                                <div class="mb-3">
                                    <label class="form-label-custom"><i class="fas fa-align-left text-primary"></i> Deskripsi Fasilitas</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              name="deskripsi" rows="3" required>{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- ROW DATA KAMAR (TOTAL & KOSONG) --}}
                                <div class="row">
                                    {{-- TOTAL KAMAR (FIELD BARU) --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom"><i class="fas fa-bed" style="color: var(--primary-color);"></i> Total Kamar</label>
                                        <input type="number" class="form-control @error('jumlah_kamar_total') is-invalid @enderror"
                                               name="jumlah_kamar_total" value="{{ old('jumlah_kamar_total', $kost->jumlah_kamar_total ?? '') }}" placeholder="Contoh: 10" min="1">
                                        @error('jumlah_kamar_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    {{-- JUMLAH KAMAR KOSONG --}}
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label-custom"><i class="fas fa-door-open" style="color: #e17055;"></i> Kamar Kosong</label>
                                        <input type="number" class="form-control @error('jumlah_kamar_kosong') is-invalid @enderror"
                                               name="jumlah_kamar_kosong" value="{{ old('jumlah_kamar_kosong', $kost->jumlah_kamar_kosong) }}" min="0" required>
                                        @error('jumlah_kamar_kosong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                {{-- KOORDINAT (OPSIONAL) --}}
                                <div class="p-3 rounded-4 mb-4" style="background: rgba(255,255,255,0.5); border: 1px dashed rgba(0,0,0,0.1);">
                                    <label class="form-label-custom mb-2"><i class="fas fa-map text-primary"></i> Titik Lokasi (Opsional)</label>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="latitude" value="{{ old('latitude', $kost->latitude) }}" placeholder="Latitude">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="longitude" value="{{ old('longitude', $kost->longitude) }}" placeholder="Longitude">
                                        </div>
                                    </div>
                                </div>

                                {{-- TOMBOL AKSI --}}
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('kost.index') }}" class="btn btn-cancel">Batal</a>
                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-save me-2"></i> Update Data
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Script Sederhana untuk Update Nama File saat Upload --}}
    <script>
        function previewFile(input) {
            var file = input.files[0];
            if(file){
                document.getElementById('fileName').innerText = file.name;
                var icon = document.querySelector('.upload-icon');
                icon.className = 'fas fa-check-circle upload-icon';
                icon.style.color = '#10b981'; 
            }
        }
    </script>
    
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>