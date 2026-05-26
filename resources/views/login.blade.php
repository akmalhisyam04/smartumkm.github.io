<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SMARTUMKM</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Tabler Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: url('{{ asset("assets/images/backgrounds/login-bg.png") }}') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        
        /* Overlay gelap di atas background */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.5) 100%);
            z-index: 0;
        }
        
        .login-container {
            width: 100%;
            max-width: 480px;
            position: relative;
            z-index: 1;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 32px;
            padding: 48px 40px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .logo {
            text-align: center;
            margin-bottom: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }
        
        .logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #1e293b, #3b82f6);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 20px -5px rgba(59, 130, 246, 0.3);
        }
        
        .logo-icon i {
            font-size: 28px;
            color: white;
        }
        
        .logo h1 {
            font-size: 32px;
            font-weight: 700;
            background: linear-gradient(135deg, #1e293b, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin: 0;
            letter-spacing: -0.5px;
        }
        
        .welcome-title {
            text-align: center;
            margin-bottom: 8px;
        }
        
        .welcome-title h2 {
            font-size: 28px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
        }
        
        .welcome-subtitle {
            text-align: center;
            margin-bottom: 32px;
        }
        
        .welcome-subtitle p {
            color: #64748b;
            font-size: 14px;
            margin: 0;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #1e293b;
            font-size: 13px;
        }
        
        .input-group-custom {
            position: relative;
        }
        
        .input-group-custom i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 18px;
        }
        
        .input-group-custom input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: #ffffff;
        }
        
        .input-group-custom input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .input-group-custom input::placeholder {
            color: #cbd5e1;
            font-size: 13px;
        }
        
        .forgot-password {
            text-align: right;
            margin-top: -8px;
            margin-bottom: 24px;
        }
        
        .forgot-password a {
            color: #3b82f6;
            font-size: 12px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background: #1e293b;
            color: white;
            border: none;
            border-radius: 14px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-login:hover {
            background: #0f172a;
            transform: translateY(-1px);
        }
        
        .register-link {
            text-align: center;
            margin: 24px 0 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }
        
        .register-link p {
            color: #64748b;
            font-size: 13px;
            margin: 0;
        }
        
        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
        
        .footer-copyright {
            text-align: center;
            margin-top: 20px;
        }
        
        .footer-copyright p {
            color: #94a3b8;
            font-size: 11px;
            margin: 0;
        }
        
        .alert-custom {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 12px 16px;
            border-radius: 14px;
            font-size: 13px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-custom i {
            font-size: 18px;
        }
        
        @media (max-width: 480px) {
            .login-card {
                padding: 32px 24px;
            }
            
            .logo {
                gap: 8px;
            }
            
            .logo-icon {
                width: 40px;
                height: 40px;
            }
            
            .logo-icon i {
                font-size: 22px;
            }
            
            .logo h1 {
                font-size: 26px;
            }
            
            .welcome-title h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="logo">
                <div class="logo-icon">
                    <i class="ti ti-building-store"></i>
                </div>
                <h1>SMARTUMKM</h1>
            </div>
            
            <div class="welcome-title">
                <h2>Selamat Datang Kembali</h2>
            </div>
            <div class="welcome-subtitle">
                <p>Masuk untuk mengelola usaha Anda</p>
            </div>

            @if(session('error'))
                <div class="alert-custom">
                    <i class="ti ti-alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('proses-login') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>USERNAME</label>
                    <div class="input-group-custom">
                        <i class="ti ti-mail"></i>
                        <input type="text" 
                                name="username" 
                                placeholder="Masukkan Username"
                                value="{{ old('username') }}"
                                required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>PASSWORD</label>
                    <div class="input-group-custom">
                        <i class="ti ti-lock"></i>
                        <input type="password" 
                                name="password" 
                                placeholder="Masukkan Password"
                                required>
                    </div>
                </div>
                
                {{-- <div class="forgot-password">
                    <a href="#">Lupa Password?</a>
                </div> --}}
                
                <button type="submit" class="btn-login">
                    Masuk <i class="ti ti-arrow-right"></i>
                </button>
            </form>
            
            {{-- <div class="register-link">
                <p>Belum memiliki akun? <a href="#">Daftar Sekarang</a></p>
            </div> --}}
            
            <div class="footer-copyright">
                <p>© {{ date('Y') }} SMARTUMKM. MEMBERDAYAKAN EKONOMI LOKAL.</p>
            </div>
        </div>
    </div>
</body>
</html>