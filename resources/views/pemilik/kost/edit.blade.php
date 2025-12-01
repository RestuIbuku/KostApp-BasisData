@extends('layouts.app')

@section('title', 'Edit Kost - Kost App')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <a href="{{ route('pemilik.kos.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>

            <div class="glass-card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="fas fa-edit"></i> Edit Data Kost</h5>
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

                    <form action="{{ route('pemilik.kos.update', $kost->kos_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- Nama Kost --}}
                            <div class="col-md-6 mb-3">
                                <label for="nama_kos" class="form-label"><i class="fas fa-heading text-primary"></i> Nama Kost</label>
                                <input type="text" class="form-control @error('nama_kos') is-invalid @enderror" id="nama_kos" name="nama_kos" value="{{ old('nama_kos', $kost->nama_kos) }}" required>
                                @error('nama_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Tipe Kost --}}
                            <div class="col-md-6 mb-3">
                                <label for="tipe_kos" class="form-label"><i class="fas fa-venus-mars text-info"></i> Tipe Kost</label>
                                <select class="form-select @error('tipe_kos') is-invalid @enderror" id="tipe_kos" name="tipe_kos" required>
                                    <option value="">-- Pilih Tipe --</option>
                                    <option value="putra" {{ old('tipe_kos', $kost->tipe_kos) == 'putra' ? 'selected' : '' }}>Putra</option>
                                    <option value="putri" {{ old('tipe_kos', $kost->tipe_kos) == 'putri' ? 'selected' : '' }}>Putri</option>
                                    <option value="campur" {{ old('tipe_kos', $kost->tipe_kos) == 'campur' ? 'selected' : '' }}>Campur</option>
                                </select>
                                @error('tipe_kos') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label"><i class="fas fa-map-marker-alt text-danger"></i> Alamat</label>
                                <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" value="{{ old('alamat', $kost->alamat) }}" required>
                                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Deskripsi --}}
                            <div class="col-12 mb-3">
                                <label for="deskripsi" class="form-label"><i class="fas fa-align-left text-primary"></i> Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Latitude --}}
                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label"><i class="fas fa-map-pin text-success"></i> Latitude</label>
                                <input type="number" step="0.00000001" class="form-control @error('latitude') is-invalid @enderror" id="latitude" name="latitude" value="{{ old('latitude', $kost->latitude) }}">
                                @error('latitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Longitude --}}
                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label"><i class="fas fa-map-pin text-success"></i> Longitude</label>
                                <input type="number" step="0.00000001" class="form-control @error('longitude') is-invalid @enderror" id="longitude" name="longitude" value="{{ old('longitude', $kost->longitude) }}">
                                @error('longitude') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Jumlah Kamar Total --}}
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_kamar_total" class="form-label"><i class="fas fa-door-open text-warning"></i> Jumlah Kamar Total</label>
                                <input type="number" min="1" class="form-control @error('jumlah_kamar_total') is-invalid @enderror" id="jumlah_kamar_total" name="jumlah_kamar_total" value="{{ old('jumlah_kamar_total', $kost->jumlah_kamar_total) }}" required>
                                @error('jumlah_kamar_total') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Jumlah Kamar Kosong --}}
                            <div class="col-md-6 mb-3">
                                <label for="jumlah_kamar_kosong" class="form-label"><i class="fas fa-door-open text-success"></i> Jumlah Kamar Kosong</label>
                                <input type="number" min="0" class="form-control @error('jumlah_kamar_kosong') is-invalid @enderror" id="jumlah_kamar_kosong" name="jumlah_kamar_kosong" value="{{ old('jumlah_kamar_kosong', $kost->jumlah_kamar_kosong) }}" required>
                                @error('jumlah_kamar_kosong') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Foto Kost --}}
                            <div class="col-12 mb-3">
                                <label for="foto" class="form-label"><i class="fas fa-image text-info"></i> Foto Kost</label>
                                @if($kost->foto)
                                    <div class="mb-2">
                                        <small class="text-muted">Foto saat ini:</small><br>
                                        <img src="{{ asset('storage/' . $kost->foto) }}" alt="Foto Kost" class="img-thumbnail" style="max-width: 300px; max-height: 200px;">
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/*">
                                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah foto. Max: 5MB</small>
                                @error('foto') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            {{-- Fasilitas Umum --}}
                            @if($fasilitas_umum->count() > 0)
                            <div class="col-12 mb-3">
                                <label class="form-label"><i class="fas fa-wifi text-primary"></i> Fasilitas Umum</label>
                                <div class="row">
                                    @foreach($fasilitas_umum as $fas)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="fas{{ $fas->fasilitas_id }}" name="fasilitas_umum[]" value="{{ $fas->fasilitas_id }}" {{ in_array($fas->fasilitas_id, $selected_fasilitas ?? []) ? 'checked' : '' }}>
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
                            <a href="{{ route('pemilik.kos.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-times"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
