<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Econic Book Store</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #2d2d2d;
            --accent-color: #005E39;
            --text-light: #ffffff;
            --text-dark: #333333;
            --bg-dark: #0f0f0f;
            --bg-light: #f8f9fa;
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            --border-radius: 8px;
            --border-radius-lg: 16px;
        }
        
        body {
            background: linear-gradient(135deg, var(--bg-dark) 0%, var(--primary-color) 50%, var(--secondary-color) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .admin-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: var(--border-radius-lg);
            box-shadow: var(--shadow);
            padding: 50px;
            width: 100%;
            max-width: 500px;
            animation: slideInUp 0.8s ease-out;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .admin-header {
            text-align: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e1e5e9;
        }
        
        .admin-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent-color) 0%, #52c713 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 20px rgba(0, 94, 57, 0.3);
        }
        
        .admin-logo i {
            font-size: 2.5rem;
            color: var(--text-light);
        }
        
        .admin-header h1 {
            color: var(--text-dark);
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .admin-header p {
            color: #808080;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        .form-group i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #808080;
            font-size: 1.2rem;
            z-index: 2;
        }
        
        .form-group input {
            width: 100%;
            padding: 18px 18px 18px 50px;
            border: 2px solid #e1e5e9;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            background: var(--bg-light);
            color: var(--text-dark);
        }
        
        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: var(--text-light);
            box-shadow: 0 0 0 4px rgba(0, 94, 57, 0.1);
            transform: translateY(-1px);
        }
        
        .form-group input::placeholder {
            color: #999;
            font-weight: 400;
        }
        
        .admin-btn {
            width: 100%;
            padding: 18px;
            background: linear-gradient(135deg, var(--accent-color) 0%, #52c713 100%);
            color: var(--text-light);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }
        
        .admin-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .admin-btn:hover::before {
            left: 100%;
        }
        
        .admin-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 30px rgba(0, 94, 57, 0.4);
        }
        
        .admin-btn:active {
            transform: translateY(0);
        }
        
        .security-info {
            background: #f8f9fa;
            border-left: 4px solid var(--accent-color);
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
        }
        
        .security-info h4 {
            color: var(--text-dark);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
        }
        
        .security-info h4 i {
            margin-right: 8px;
            color: var(--accent-color);
        }
        
        .security-info p {
            color: #808080;
            font-size: 0.8rem;
            line-height: 1.4;
        }
        
        .error-message {
            background: #fee;
            color: #c33;
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            border-left: 4px solid #c33;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .success-message {
            background: #efe;
            color: #363;
            padding: 15px;
            border-radius: var(--border-radius);
            margin-bottom: 25px;
            border-left: 4px solid #363;
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        .back-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #e1e5e9;
        }
        
        .back-link a {
            color: #808080;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
            display: inline-flex;
            align-items: center;
        }
        
        .back-link a:hover {
            color: var(--accent-color);
        }
        
        .back-link a i {
            margin-right: 6px;
        }
        
        .captcha-section {
            margin-bottom: 25px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: var(--border-radius);
            border: 1px solid #e1e5e9;
        }
        
        .captcha-section h4 {
            color: var(--text-dark);
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .captcha-section h4 i {
            margin-right: 8px;
            color: var(--accent-color);
        }
        
        .captcha-input {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .captcha-display {
            background: var(--text-dark);
            color: var(--text-light);
            padding: 10px 15px;
            border-radius: var(--border-radius);
            font-family: 'Courier New', monospace;
            font-weight: bold;
            letter-spacing: 2px;
            min-width: 120px;
            text-align: center;
        }
        
        .captcha-refresh {
            background: var(--accent-color);
            color: var(--text-light);
            border: none;
            border-radius: var(--border-radius);
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .captcha-refresh:hover {
            background: #004d2e;
            transform: rotate(180deg);
        }
        
        @media (max-width: 480px) {
            .admin-container {
                padding: 40px 25px;
            }
            
            .admin-header h1 {
                font-size: 1.5rem;
            }
            
            .admin-logo {
                width: 60px;
                height: 60px;
            }
            
            .admin-logo i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-logo">
                <i class='bx bxs-book'></i>
            </div>
            <h1>Admin Panel</h1>
            <p>Akses terbatas untuk administrator</p>
        </div>
        
        @if ($errors->any())
            <div class="error-message">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="security-info">
            <h4><i class='bx bx-info-circle'></i> Keamanan Admin</h4>
            <p>Sistem ini menggunakan autentikasi dua faktor dan enkripsi tingkat enterprise untuk melindungi data sensitif.</p>
        </div>
        
        <form action="{{ route('admin.login') }}" method="POST" id="adminLoginForm">
            @csrf
            
            <div class="form-group">
                <i class='bx bx-envelope'></i>
                <input type="email" name="email" placeholder="Email Administrator" required value="{{ old('email') }}">
            </div>
            
            <div class="form-group">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="password" placeholder="Password Administrator" required>
            </div>
            
            <!-- <div class="captcha-section">
                <h4><i class='bx bx-shield'></i> Verifikasi Keamanan</h4>
                <div class="captcha-input">
                    <div class="captcha-display" id="captchaDisplay">A7B9</div>
                    <button type="button" class="captcha-refresh" onclick="generateCaptcha()">
                        <i class='bx bx-refresh'></i>
                    </button>
                    <input type="text" name="captcha" placeholder="Masukkan kode" required style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div> -->
            
            <button type="submit" class="admin-btn">
                <i class='bx bx-log-in'></i> Masuk sebagai Admin
            </button>
        </form>
        
        <div class="back-link">
            <a href="{{ route('user.login') }}">
                <i class='bx bx-arrow-back'></i>
                Kembali ke Login User
            </a>
        </div>
    </div>
    
    <script>
        // // Generate random captcha
        // function generateCaptcha() {
        //     const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        //     let result = '';
        //     for (let i = 0; i < 4; i++) {
        //         result += chars.charAt(Math.floor(Math.random() * chars.length));
        //     }
        //     document.getElementById('captchaDisplay').textContent = result;
        // }
        
        // // Initialize captcha on page load
        // generateCaptcha();
        
        // // Form validation
        // document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
        //     const captchaInput = document.querySelector('input[name="captcha"]');
        //     const captchaDisplay = document.getElementById('captchaDisplay').textContent;
            
        //     if (captchaInput.value.toUpperCase() !== captchaDisplay) {
        //         e.preventDefault();
        //         alert('Kode verifikasi tidak sesuai!');
        //         generateCaptcha();
        //         captchaInput.value = '';
        //         captchaInput.focus();
        //     }
        // });
        
        // // Auto-refresh captcha every 2 minutes
        // setInterval(generateCaptcha, 120000);
    </script>
</body>
</html>
