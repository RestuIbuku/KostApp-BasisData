<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kost App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Kost App</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link">{{ Auth::user()->nama_lengkap }}</span>
                @if(Auth::user()->role == 'pemilik')
                    <a href="{{ route('kost.index') }}" class="nav-link">Kelola Kost</a>
                @endif
                <a href="{{ route('logout') }}" class="nav-link">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Dashboard</div>
                    <div class="card-body">
                        <h5>Selamat Datang, {{ Auth::user()->nama_lengkap }}</h5>
                        <p>Role: {{ Auth::user()->role }}</p>

                        @if(Auth::user()->role == 'pemilik')
                            <div class="mt-4">
                                <a href="{{ route('kost.index') }}" class="btn btn-primary">
                                    Kelola Data Kost
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
