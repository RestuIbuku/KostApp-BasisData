<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Kost App</a>
            @auth
            <div class="navbar-nav">
                @if(Auth::user()->role == 'pemilik')
                    <a class="nav-link" href="{{ route('kost.index') }}">Kelola Kost</a>
                @endif
                <span class="nav-link">{{ Auth::user()->nama_lengkap }}</span>
                <a href="{{ route('logout') }}" class="nav-link">Logout</a>
            </div>
            @endauth
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
