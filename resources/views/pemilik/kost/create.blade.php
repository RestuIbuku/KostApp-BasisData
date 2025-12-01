<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kost - Kost App</title>

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

        .page-wrapper {
            padding: 3rem 0 5rem;
        }

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
            background: linear-gradient(135deg, var(--primary-color), #8f89ff);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            box-shadow: 0 8px 15px rgba(108, 99, 255, 0.3);
        }

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

        .nav-tabs {
            border-bottom: 2px solid rgba(108, 99, 255, 0.2);
            gap: 1rem;
        }

        .nav-link {
            color: var(--text-muted);
            border: none;
            border-bottom: 3px solid transparent;
            font-weight: 600;
            padding: 0.8rem 1rem;
            transition: all 0.3s;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background: none;
        }

        .nav-link.active {
            color: var(--primary-color);
            background: none;
            border-bottom-color: var(--primary-color);
        }

        .tab-content {
            padding-top: 1.5rem;
        }

        .fasilitas-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .fasilitas-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px solid rgba(108, 99, 255, 0.2);
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s;
            background: rgba(255, 255, 255, 0.5);
        }

        .fasilitas-item:hover {
            border-color: var(--primary-color);
            background: rgba(108, 99, 255, 0.05);
            transform: translateY(-2px);
        }

        .fasilitas-item input[type="checkbox"] {
            cursor: pointer;
            margin-right: 0.5rem;
            width: 18px;
            height: 18px;
        }

        .fasilitas-item label {
            cursor: pointer;
            margin: 0;
            font-weight: 500;
            flex: 1;
        }

        .kamar-form-section {
            background: rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(108, 99, 255, 0.15);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .kamar-form-section h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .btn-add-kamar {
            background: linear-gradient(135deg, #00b894, #009970);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            transition: all 0.3s;
            margin-top: 1rem;
            cursor: pointer;
        }

        .btn-add-kamar:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 184, 148, 0.3);
            color: white;
        }

        .btn-remove-kamar {
            background: linear-gradient(135deg, #ff7675, #d63031);
            border: none;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-remove-kamar:hover {
            box-shadow: 0 5px 15px rgba(214, 48, 49, 0.3);
            color: white;
        }

        .section-divider {
            border-top: 2px solid rgba(108, 99, 255, 0.1);
            margin: 2rem 0;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="page-wrapper">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">

                    <div class="mb-3">
                        <a href="{{ route('pemilik.kos.index') }}" class="btn-back">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>

                    <div class="glass-card">
                        <div class="form-header">
                            <div class="header-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0" style="color: var(--text-dark);">Tambah Kost Baru</h4>
                                <small style="color: var(--text-muted);">Lengkapi data kost, kamar, dan fasilitas</small>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('pemilik.kos.store') }}" method="POST" enctype="multipart/form-data" id="formTambahKos">
                                @csrf

                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab-info-tab" data-bs-toggle="tab" data-bs-target="#tab-info" type="button" role="tab">
                                            <i class="fas fa-info-circle me-2"></i> Informasi Kost
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-fasilitas-tab" data-bs-toggle="tab" data-bs-target="#tab-fasilitas" type="button" role="tab">
                                            <i class="fas fa-star me-2"></i> Fasilitas Umum
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-kamar-tab" data-bs-toggle="tab" data-bs-target="#tab-kamar" type="button" role="tab">
                                            <i class="fas fa-bed me-2"></i> Daftar Kamar
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content" id="tabContent">
                                    <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="mb-3">
                                                    <label class="form-label-custom"><i class="fas fa-heading" style="color: var(--primary-color);"></i> Nama Kost</label>
                                                    <input type="text" class="form-control @error('nama_kos') is-invalid @enderror"
                                                           name="nama_kos" value="{{ old('nama_kos') }}" placeholder="Contoh: Kost Bahagia" required>
                                                    @error('nama_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label-custom"><i class="fas fa-venus-mars" style="color: var(--secondary-color);"></i> Tipe Kost</label>
                                                    <select class="form-select @error('tipe_kos') is-invalid @enderror" name="tipe_kos" required>
                                                        <option value="">Pilih Tipe...</option>
                                                        <option value="putra" {{ old('tipe_kos') == 'putra' ? 'selected' : '' }}>👨 Putra</option>
                                                        <option value="putri" {{ old('tipe_kos') == 'putri' ? 'selected' : '' }}>👩 Putri</option>
                                                        <option value="campur" {{ old('tipe_kos') == 'campur' ? 'selected' : '' }}>👥 Campur</option>
                                                    </select>
                                                    @error('tipe_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label-custom"><i class="fas fa-image" style="color: #00b894;"></i> Foto Kost</label>
                                                <div class="file-upload-wrapper">
                                                    <input type="file" class="file-upload-input @error('foto') is-invalid @enderror" name="foto" accept="image/*" onchange="previewFile(this)">
                                                    <div class="text-center p-3">
                                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                                        <p class="mb-0 fw-semibold text-muted" id="fileName" style="font-size: 0.9rem;">Klik atau Geser foto ke sini</p>
                                                        <small class="text-muted" style="font-size: 0.75rem;">Max: 5MB (JPG/PNG)</small>
                                                    </div>
                                                </div>
                                                @error('foto') <div class="text-danger mt-1 small">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-custom"><i class="fas fa-map-marker-alt text-danger"></i> Alamat Lengkap</label>
                                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                      name="alamat" rows="2" placeholder="Masukkan alamat lengkap..." required>{{ old('alamat') }}</textarea>
                                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label-custom"><i class="fas fa-align-left text-primary"></i> Deskripsi Kost</label>
                                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                                      name="deskripsi" rows="3" placeholder="Jelaskan tentang kost Anda..." required>{{ old('deskripsi') }}</textarea>
                                            @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label-custom"><i class="fas fa-bed" style="color: var(--primary-color);"></i> Total Kamar</label>
                                                <input type="number" class="form-control @error('jumlah_kamar_total') is-invalid @enderror"
                                                       name="jumlah_kamar_total" value="{{ old('jumlah_kamar_total') }}" placeholder="Contoh: 10" min="1" required>
                                                @error('jumlah_kamar_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label-custom"><i class="fas fa-door-open" style="color: #e17055;"></i> Kamar Kosong</label>
                                                <input type="number" class="form-control @error('jumlah_kamar_kosong') is-invalid @enderror"
                                                       name="jumlah_kamar_kosong" value="{{ old('jumlah_kamar_kosong') }}" placeholder="Contoh: 5" min="0" required>
                                                @error('jumlah_kamar_kosong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>

                                        <div class="p-3 rounded-4 mb-4" style="background: rgba(255,255,255,0.5); border: 1px dashed rgba(0,0,0,0.1);">
                                            <label class="form-label-custom mb-2"><i class="fas fa-map text-primary"></i> Titik Lokasi (Opsional)</label>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="latitude" value="{{ old('latitude') }}" placeholder="Latitude (Garis Lintang)">
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" name="longitude" value="{{ old('longitude') }}" placeholder="Longitude (Garis Bujur)">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-fasilitas" role="tabpanel">
                                        <div class="mb-3">
                                            <label class="form-label-custom mb-3"><i class="fas fa-star me-2" style="color: #f39c12;"></i> Pilih Fasilitas Umum Kost</label>
                                            <p class="text-muted small">Fasilitas umum adalah fasilitas bersama untuk semua penghuni kost</p>
                                            <div class="fasilitas-grid">
                                                @if(isset($fasilitas_umum) && count($fasilitas_umum) > 0)
                                                    @foreach($fasilitas_umum as $fasilitas)
                                                    <div class="fasilitas-item">
                                                        <input type="checkbox" id="fas_umum_{{ $fasilitas->fasilitas_id }}"
                                                               name="fasilitas_umum[]" value="{{ $fasilitas->fasilitas_id }}"
                                                               {{ in_array($fasilitas->fasilitas_id, old('fasilitas_umum', [])) ? 'checked' : '' }}>
                                                        <label for="fas_umum_{{ $fasilitas->fasilitas_id }}">{{ $fasilitas->nama_fasilitas }}</label>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-info">Tidak ada fasilitas umum tersedia</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tab-kamar" role="tabpanel">
                                        <div>
                                            <label class="form-label-custom mb-3"><i class="fas fa-bed me-2" style="color: var(--primary-color);"></i> Tambahkan Kamar</label>
                                            <p class="text-muted small">Tambahkan satu atau lebih kamar yang tersedia di kost</p>

                                            <div id="kamarContainer">
                                                <div class="kamar-form-section mb-3" data-index="0">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h5 class="mb-0"><i class="fas fa-door-open me-2"></i>Kamar 1</h5>
                                                        <button type="button" class="btn-remove-kamar d-none" onclick="removeKamar(this)">
                                                            <i class="fas fa-trash me-1"></i> Hapus
                                                        </button>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label-custom"><i class="fas fa-heading"></i> Nama Kamar</label>
                                                            <input type="text" class="form-control" name="kamar[0][nama_kamar]" placeholder="Contoh: Kamar 101" required>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label-custom"><i class="fas fa-money-bill"></i> Harga/Malam</label>
                                                            <input type="number" class="form-control" name="kamar[0][harga_per_malam]" placeholder="Contoh: 500000" min="0" required>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label-custom"><i class="fas fa-expand"></i> Ukuran Kamar</label>
                                                            <input type="text" class="form-control" name="kamar[0][ukuran_kamar]" placeholder="Contoh: 4x5 m">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label-custom"><i class="fas fa-check"></i> Status Ketersediaan</label>
                                                            <select class="form-select" name="kamar[0][status_ketersediaan]" required>
                                                                <option value="tersedia">Tersedia</option>
                                                                <option value="penuh">Penuh</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label class="form-label-custom"><i class="fas fa-star"></i> Fasilitas Kamar</label>
                                                        <div class="fasilitas-grid" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));">
                                                            @if(isset($fasilitas_kamar) && count($fasilitas_kamar) > 0)
                                                                @foreach($fasilitas_kamar as $fasilitas)
                                                                <div class="fasilitas-item" style="padding: 0.7rem;">
                                                                    <input type="checkbox" id="fas_kamar_0_{{ $fasilitas->fasilitas_id }}"
                                                                           name="kamar[0][fasilitas][]" value="{{ $fasilitas->fasilitas_id }}">
                                                                    <label for="fas_kamar_0_{{ $fasilitas->fasilitas_id }}" style="font-size: 0.85rem;">{{ $fasilitas->nama_fasilitas }}</label>
                                                                </div>
                                                                @endforeach
                                                            @else
                                                                <div class="alert alert-info">Tidak ada fasilitas tersedia</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-add-kamar" onclick="addKamar()">
                                                <i class="fas fa-plus me-2"></i> Tambah Kamar Lagi
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="section-divider"></div>
                                <div class="d-flex gap-2 justify-content-end">
                                    <a href="{{ route('pemilik.kos.index') }}" class="btn btn-cancel">Batal</a>
                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-check-circle me-2"></i> Simpan Semua Data
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let kamarCount = 1;
        const fasilitasKamarData = @json(isset($fasilitas_kamar) ? $fasilitas_kamar : []);

        function previewFile(input) {
            var file = input.files[0];
            if(file){
                document.getElementById('fileName').innerText = file.name;
                var icon = document.querySelector('.upload-icon');
                icon.className = 'fas fa-check-circle upload-icon';
                icon.style.color = '#10b981';
            }
        }

        function generateFasilitasHTML(index) {
            let html = '';
            fasilitasKamarData.forEach(fasilitas => {
                html += `
                    <div class="fasilitas-item" style="padding: 0.7rem;">
                        <input type="checkbox" id="fas_kamar_${index}_${fasilitas.fasilitas_id}"
                               name="kamar[${index}][fasilitas][]" value="${fasilitas.fasilitas_id}">
                        <label for="fas_kamar_${index}_${fasilitas.fasilitas_id}" style="font-size: 0.85rem;">${fasilitas.nama_fasilitas}</label>
                    </div>
                `;
            });
            return html || '<div class="alert alert-info">Tidak ada fasilitas tersedia</div>';
        }

        function addKamar() {
            const container = document.getElementById('kamarContainer');
            const newIndex = kamarCount;

            const kamarHTML = `
                <div class="kamar-form-section mb-3" data-index="${newIndex}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="fas fa-door-open me-2"></i>Kamar ${newIndex + 1}</h5>
                        <button type="button" class="btn-remove-kamar" onclick="removeKamar(this)">
                            <i class="fas fa-trash me-1"></i> Hapus
                        </button>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label-custom"><i class="fas fa-heading"></i> Nama Kamar</label>
                            <input type="text" class="form-control" name="kamar[${newIndex}][nama_kamar]" placeholder="Contoh: Kamar 102" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label-custom"><i class="fas fa-money-bill"></i> Harga/Malam</label>
                            <input type="number" class="form-control" name="kamar[${newIndex}][harga_per_malam]" placeholder="Contoh: 500000" min="0" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label class="form-label-custom"><i class="fas fa-expand"></i> Ukuran Kamar</label>
                            <input type="text" class="form-control" name="kamar[${newIndex}][ukuran_kamar]" placeholder="Contoh: 4x5 m">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label-custom"><i class="fas fa-check"></i> Status Ketersediaan</label>
                            <select class="form-select" name="kamar[${newIndex}][status_ketersediaan]" required>
                                <option value="tersedia">Tersedia</option>
                                <option value="penuh">Penuh</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-custom"><i class="fas fa-star"></i> Fasilitas Kamar</label>
                        <div class="fasilitas-grid" style="grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));">
                            ${generateFasilitasHTML(newIndex)}
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', kamarHTML);
            kamarCount++;
            updateRemoveButtons();
        }

        function removeKamar(button) {
            const section = button.closest('.kamar-form-section');
            section.style.opacity = '0';
            section.style.transition = 'all 0.3s ease';
            setTimeout(() => {
                section.remove();
                updateRemoveButtons();
            }, 300);
        }

        function updateRemoveButtons() {
            const sections = document.querySelectorAll('.kamar-form-section');
            sections.forEach(section => {
                const btn = section.querySelector('.btn-remove-kamar');
                if (sections.length > 1) {
                    btn.classList.remove('d-none');
                } else {
                    btn.classList.add('d-none');
                }
            });
        }

        document.getElementById('formTambahKos').addEventListener('submit', function(e) {
            const kamarSections = document.querySelectorAll('.kamar-form-section');
            if (kamarSections.length === 0) {
                e.preventDefault();
                alert('Minimal harus ada 1 kamar. Silakan tambahkan kamar terlebih dahulu.');
                return false;
            }
        });

        updateRemoveButtons();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
