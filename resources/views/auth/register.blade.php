<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Kost App</title>

    {{-- Font Awesome & Google Fonts --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #FF6584;
            --text-dark: #2D3436;
            --text-light: #A4B0BE;
            --glass-bg: rgba(255, 255, 255, 0.75);
            --glass-border: rgba(255, 255, 255, 0.4);
            --shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            overflow-x: hidden;
            position: relative;
            padding: 2rem 0;
        }

        /* Animated Background Blobs (Sama dengan Login) */
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
            filter: blur(50px);
            opacity: 0.6;
            animation: float 10s infinite ease-in-out alternate;
        }

        .shape-1 {
            top: -10%;
            right: -5%;
            width: 500px;
            height: 500px;
            background: var(--primary-color);
            border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        }

        .shape-2 {
            bottom: -10%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: var(--secondary-color);
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(20px, 40px) rotate(10deg); }
        }

        /* Card Container */
        .register-card {
            width: 100%;
            max-width: 500px;
            padding: 2.5rem;
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            box-shadow: var(--shadow);
            animation: slideUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1);
            margin: 20px;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Header Section */
        .register-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .app-logo {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary-color), #8f89ff);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.8rem;
            margin-bottom: 1rem;
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            transform: rotate(-5deg);
            transition: transform 0.3s ease;
        }

        .register-card:hover .app-logo {
            transform: rotate(0deg) scale(1.05);
        }

        .register-header h2 {
            color: var(--text-dark);
            font-weight: 700;
            font-size: 1.6rem;
            letter-spacing: -0.5px;
        }

        .register-header p {
            color: #636e72;
            font-size: 0.9rem;
            margin-top: 0.3rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: #57606f;
            margin-left: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a4b0be;
            font-size: 1.1rem;
            transition: color 0.3s ease;
            z-index: 2;
        }

        .form-input, .form-select {
            width: 100%;
            padding: 0.9rem 1rem 0.9rem 3rem;
            background: rgba(255, 255, 255, 0.8);
            border: 2px solid transparent;
            border-radius: 16px;
            font-size: 0.95rem;
            color: var(--text-dark);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            appearance: none; /* Remove default arrow on select */
        }

        .form-input::placeholder { color: #ced6e0; }

        .form-input:focus, .form-select:focus {
            outline: none;
            background: #fff;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(108, 99, 255, 0.1);
        }

        .form-input:focus + .input-icon,
        .form-select:focus + .input-icon {
            color: var(--primary-color);
        }

        .form-input.is-invalid, .form-select.is-invalid {
            border-color: #ff4757;
            background: #fff1f2;
        }

        /* Custom styling for Select arrow */
        .select-arrow {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            color: #a4b0be;
            pointer-events: none;
        }

        .password-toggle {
            position: absolute;
            right: 1.2rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a4b0be;
            transition: color 0.3s;
            z-index: 3;
        }

        .password-toggle:hover { color: var(--primary-color); }

        /* Button */
        .btn-register {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary-color), #5a52d5);
            color: white;
            border: none;
            border-radius: 16px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 1.5rem;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(108, 99, 255, 0.4);
        }

        /* Footer */
        .login-text {
            text-align: center;
            font-size: 0.9rem;
            color: #747d8c;
            margin-top: 1.5rem;
        }

        .login-text a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            position: relative;
        }

        .login-text a::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: var(--primary-color);
            transform: scaleX(0);
            transition: transform 0.3s ease;
            transform-origin: right;
        }

        .login-text a:hover::after {
            transform: scaleX(1);
            transform-origin: left;
        }

        .invalid-feedback {
            color: #ff4757;
            font-size: 0.8rem;
            margin-top: 0.5rem;
            margin-left: 0.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-card { padding: 2rem 1.5rem; }
            .shape-1 { width: 300px; height: 300px; }
            .shape-2 { width: 250px; height: 250px; }
        }
    </style>
</head>
<body>

    <div class="background-shapes">
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
    </div>

    <div class="register-card">
        <div class="register-header">
            <div class="app-logo">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Bergabunglah dengan komunitas Kost App</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- 1. NAMA LENGKAP --}}
            <div class="form-group">
                <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                <div class="input-wrapper">
                    <input 
                        id="nama_lengkap" 
                        type="text" 
                        class="form-input @error('nama_lengkap') is-invalid @enderror" 
                        name="nama_lengkap" 
                        value="{{ old('nama_lengkap') }}" 
                        required 
                        autofocus
                        placeholder="Nama Lengkap Anda"
                    >
                    <i class="fas fa-user input-icon"></i>
                </div>
                @error('nama_lengkap')
                    <span class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="row" style="display: flex; gap: 15px; flex-wrap: wrap;">
                {{-- 2. EMAIL --}}
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label for="email" class="form-label">Email</label>
                    <div class="input-wrapper">
                        <input 
                            id="email" 
                            type="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required
                            placeholder="nama@email.com"
                        >
                        <i class="fas fa-envelope input-icon"></i>
                    </div>
                    @error('email')
                        <span class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>

                {{-- 3. NO HP --}}
                <div class="form-group" style="flex: 1; min-width: 200px;">
                    <label for="no_hp" class="form-label">No WhatsApp</label>
                    <div class="input-wrapper">
                        <input 
                            id="no_hp" 
                            type="number" 
                            class="form-input @error('no_hp') is-invalid @enderror" 
                            name="no_hp" 
                            value="{{ old('no_hp') }}" 
                            required
                            placeholder="0812..."
                        >
                        <i class="fas fa-phone input-icon"></i>
                    </div>
                    @error('no_hp')
                        <span class="invalid-feedback">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            {{-- 4. ROLE --}}
            <div class="form-group">
                <label for="role" class="form-label">Daftar Sebagai</label>
                <div class="input-wrapper">
                    <select id="role" class="form-select @error('role') is-invalid @enderror" name="role" required>
                        <option value="" disabled selected>Pilih Tipe Akun...</option>
                        <option value="pencari">🏃‍♂️ Pencari Kost (Ingin sewa)</option>
                        <option value="pemilik">🏠 Pemilik Kost (Ingin iklan)</option>
                    </select>
                    <i class="fas fa-user-tag input-icon"></i>
                    <i class="fas fa-chevron-down select-arrow"></i>
                </div>
                @error('role')
                    <span class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            {{-- 5. PASSWORD --}}
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <div class="input-wrapper">
                    <input 
                        id="password" 
                        type="password" 
                        class="form-input @error('password') is-invalid @enderror" 
                        name="password" 
                        required
                        placeholder="••••••••"
                    >
                    <i class="fas fa-lock input-icon"></i>
                    <i class="fas fa-eye password-toggle" onclick="togglePassword()"></i>
                </div>
                @error('password')
                    <span class="invalid-feedback">
                        <i class="fas fa-exclamation-circle"></i> {{ $message }}
                    </span>
                @enderror
            </div>

            <button type="submit" class="btn-register">
                <span>Daftar Sekarang</span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <div class="login-text">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk disini</a>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>