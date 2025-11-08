<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Econic Book Store</title>
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
            --primary-color: #005E39;
            --secondary-color: #52c713;
            --accent-color: #FD9852;
            --text-dark: #323232;
            --text-light: #005E39;
            --bg-light: #f4f4f4;
            --shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            --border-radius: 12px;
            /* Dark mode color */
            --white: #fafdff;
            --black: #323232;

            --whitegray: #b9b9b9;

            /* Primary Color */
            --green1: #005E39;
            --green2: #52c713;
            --green3: ;

            /* Secondary color */
            --orange1: #FD9852;
            --orange2: ;
            --whitecream: #FBEAE0;

            /* Shadow */
            --shadow1: 0 2px 10px rgba(0, 0, 0, 0.1);
            --shadow2: 0 4px 6px rgba(255, 255, 255, 0.4);
            /* Discount */
            --discount1: ;
            --discount2: ;

            /* Font Size */
            --fontsize1: 3.2rem;
            --fontsize2: 2.7rem;
            --fontsize3: 2.3rem;
            --fontsize4: 2.1rem;
            --fontsize5: 1.9rem;
            --fontsize6: 1.6rem;
            --fontsize7: 1.2rem;

            /* Radius */
            --radius-6: 6px;
            --radius-12: 12px;
            --radius-24: 24px;
            --radius-32: 32px;
            --radius-circle: 50%;

            /* Font Weight */
            --weight-thin: 300;
            --weight-normal: 400;
            --weight-medium: 500;
            --weight-semibold: 600;
            --weight-bold: 700;
            --weight-extrabold: 800;
        }

        body {
            background: var(--green1);
            /* background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); */
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            background: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-section h1 {
            color: var(--green3);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .logo-section p {
            color: var(--green1);
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-light);
            font-size: 1.1rem;
        }

        .form-group input {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 2px solid #e1e5e9;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(0, 94, 57, 0.1);
        }

        .form-group input::placeholder {
            color: var(--text-light);
        }

        .register-btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 20px;
        }

        .register-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 94, 57, 0.3);
        }

        .register-btn:active {
            transform: translateY(0);
        }

        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
            color: var(--text-light);
            font-size: 0.9rem;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
            z-index: 1;
        }

        .divider span {
            background: var(--white);
            padding: 0 15px;
            position: relative;
            z-index: 2;
        }

        .auth-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .auth-link {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            border: 2px solid #e1e5e9;
            border-radius: var(--border-radius);
            color: var(--text-dark);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .auth-link:hover {
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .auth-link i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .error-message {
            background: #fee;
            color: #c33;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border-left: 4px solid #c33;
            font-size: 0.9rem;
        }

        .success-message {
            background: #efe;
            color: #363;
            padding: 12px;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            border-left: 4px solid #363;
            font-size: 0.9rem;
        }

        .admin-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .admin-link a {
            color: var(--text-light);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .admin-link a:hover {
            color: var(--green1);
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }

            .logo-section h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo-section">
            <h1><i class='bx bxs-book'></i> Econic Book Store</h1>
            <p>Daftar akun baru untuk mulai berbelanja</p>
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

        <form action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <i class='bx bx-user'></i>
                <input type="text" name="name" placeholder="Nama Lengkap" required value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <i class='bx bx-envelope'></i>
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <i class='bx bx-lock-alt'></i>
                <input type="password" name="password" placeholder="Password (Minimal 8 karakter)" required>
            </div>

            <div class="form-group">
                <i class='bx bx-lock'></i>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            </div>

            <button type="submit" class="register-btn">
                <i class='bx bx-user-plus'></i> Daftar
            </button>
        </form>

        <div class="divider">
            <span>atau</span>
        </div>

        <div class="auth-links">
            <a href="{{ route('user.login') }}" class="auth-link">
                <i class='bx bx-log-in'></i>
                Masuk ke Akun
            </a>
            <a href="#" class="auth-link">
                <i class='bx bx-key'></i>
                Lupa Password?
            </a>
        </div>

        <div class="admin-link">
            <a href="{{ route('admin.login') }}">Login sebagai Admin</a>
        </div>
    </div>
</body>

</html>
