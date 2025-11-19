@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-3">
        <div class="col-md-12">
            <h2>Daftar Kost Saya</h2>
            <a href="{{ route('kost.create') }}" class="btn btn-primary">Tambah Kost</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nama Kost</th>
                                    <th>Alamat</th>
                                    <th>Tipe</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($kosts as $kost)
                                <tr>
                                    <td>{{ $kost->nama_kos }}</td>
                                    <td>{{ $kost->alamat }}</td>
                                    <td>{{ ucfirst($kost->tipe_kos) }}</td>
                                    <td>
                                        <a href="{{ route('kost.edit', $kost->kos_id) }}" class="btn btn-sm btn-warning">Edit</a>
                                        <form action="{{ route('kost.destroy', $kost->kos_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
