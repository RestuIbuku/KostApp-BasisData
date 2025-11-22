<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loading... - Kost App</title>
    
    {{-- Font Awesome & Google Fonts --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden; /* Mencegah scroll saat splash screen */
        }

        /* === CONTAINER UTAMA === */
        .splash-screen {
            height: 100vh;
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            color: white;
        }

        /* Pattern Background Halus */
        .splash-screen::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(255,255,255,0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        /* === LOGO ANIMATION WRAPPER === */
        .logo-container {
            position: relative;
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
        }

        /* Lingkaran Putih Ikon */
        .logo-circle {
            width: 100px;
            height: 100px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #764ba2;
            font-size: 3rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            z-index: 2;
            animation: float 3s ease-in-out infinite;
        }

        /* Efek Ripple (Gelombang) */
        .ripple {
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            z-index: 1;
            animation: ripple-effect 2s infinite linear;
        }
        
        .ripple:nth-child(2) {
            animation-delay: 0.5s;
        }

        /* === TEXT TYPOGRAPHY === */
        .app-name {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 10px rgba(0,0,0,0.2);
            opacity: 0;
            animation: fadeInUp 0.8s ease forwards 0.3s;
        }

        .tagline {
            font-size: 1rem;
            font-weight: 400;
            opacity: 0;
            letter-spacing: 1px;
            animation: fadeInUp 0.8s ease forwards 0.6s;
        }

        /* === LOADING DOTS === */
        .loading-dots {
            margin-top: 3rem;
            display: flex;
            gap: 8px;
        }

        .dot {
            width: 10px;
            height: 10px;
            background-color: rgba(255,255,255,0.8);
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .dot:nth-child(1) { animation-delay: -0.32s; }
        .dot:nth-child(2) { animation-delay: -0.16s; }

        /* === KEYFRAMES ANIMATION === */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes ripple-effect {
            0% { transform: scale(0.8); opacity: 1; }
            100% { transform: scale(2.5); opacity: 0; }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes bounce {
            0%, 80%, 100% { transform: scale(0); }
            40% { transform: scale(1); }
        }
    </style>
</head>
<body>

    <div class="splash-screen">
        {{-- Logo Container dengan Efek Ripple --}}
        <div class="logo-container">
            <div class="ripple"></div>
            <div class="ripple"></div>
            <div class="logo-circle">
                <i class="fas fa-home"></i>
            </div>
        </div>

        {{-- Teks Aplikasi --}}
        <h1 class="app-name">KOST APP</h1>
        <p class="tagline">Cari Hunian Nyaman Impianmu</p>

        {{-- Loading Indicator --}}
        <div class="loading-dots">
            <div class="dot"></div>
            <div class="dot"></div>
            <div class="dot"></div>
        </div>
    </div>

    {{-- SCRIPT PENGALIHAN OTOMATIS --}}
    <script>
        // Waktu tunggu dalam milidetik (3000ms = 3 detik)
        setTimeout(function() {
            // Ganti 'login' dengan route tujuan kamu (misal: 'pencari.index' atau 'login')
            window.location.href = "{{ route('login') }}"; 
        }, 3000);
    </script>

</body>
</html>