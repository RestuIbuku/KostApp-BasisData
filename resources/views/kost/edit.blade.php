@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">Edit Kost</div>
                <div class="card-body">
                    <form action="{{ route('kost.update', $kost->kos_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Nama Kost</label>
                            <input type="text" class="form-control @error('nama_kos') is-invalid @enderror"
                                   name="nama_kos" value="{{ old('nama_kos', $kost->nama_kos) }}">
                            @error('nama_kos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      name="alamat">{{ old('alamat', $kost->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                      name="deskripsi">{{ old('deskripsi', $kost->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipe Kost</label>
                            <select class="form-control @error('tipe_kos') is-invalid @enderror" name="tipe_kos">
                                <option value="">Pilih Tipe</option>
                                <option value="putra" {{ old('tipe_kos', $kost->tipe_kos) == 'putra' ? 'selected' : '' }}>Putra</option>
                                <option value="putri" {{ old('tipe_kos', $kost->tipe_kos) == 'putri' ? 'selected' : '' }}>Putri</option>
                                <option value="campur" {{ old('tipe_kos', $kost->tipe_kos) == 'campur' ? 'selected' : '' }}>Campur</option>
                            </select>
                            @error('tipe_kos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control @error('latitude') is-invalid @enderror"
                                   name="latitude" value="{{ old('latitude', $kost->latitude) }}">
                            @error('latitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control @error('longitude') is-invalid @enderror"
                                   name="longitude" value="{{ old('longitude', $kost->longitude) }}">
                            @error('longitude')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('kost.index') }}" class="btn btn-link">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
