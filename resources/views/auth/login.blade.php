<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASMA - Masuk</title>
    <style>
        /* Gaya CSS */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }
        .logo {
            font-size: 32px;
            color: #1e88e5; 
            margin-bottom: 10px;
        }
        h2 {
            font-size: 24px;
            margin-bottom: 5px;
            color: #333;
        }
        h3 {
            font-size: 16px;
            font-weight: normal;
            margin-bottom: 20px;
            color: #666;
        }
        h4 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #333;
        }
        /* Style untuk pesan kesalahan */
        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            text-align: left;
        }
        .input-error {
            border-color: #dc3545 !important;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; 
            padding-left: 40px; 
        }
        .input-group {
            position: relative;
        }
        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #aaa;
            pointer-events: none;
        }
        button {
            width: 100%;
            background-color: #1e88e5;
            color: white;
            padding: 14px 20px;
            margin: 15px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-transform: uppercase;
            font-weight: bold;
        }
        button:hover {
            background-color: #1565c0;
        }
        .link-text {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
        .link-text a {
            color: #1e88e5;
            text-decoration: none;
            font-weight: bold;
        }
        .link-text a:hover {
            text-decoration: underline;
        }
        /* Style baru untuk link lupa password */
        .forgot-password-link {
            text-align: right;
            margin-top: -10px; 
            margin-bottom: 10px; 
            font-size: 13px;
        }
        .forgot-password-link a {
            color: #1e88e5;
            text-decoration: none;
        }
        .forgot-password-link a:hover {
            text-decoration: underline;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="logo"><i class="fas fa-sign-in-alt"></i></div>
        <h2>GASMA</h2>
        <h3>Gas Safety Monitoring Assistant</h3>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
        <h4>Masuk Akun</h4>

        @error('username')
            <div class="alert-error">
                {{ $message }}
            </div>
        @enderror

        <form action="{{ route('login.post') }}" method="POST">
            @csrf 
            
            <div class="input-group">
                <i class="fas fa-user-tag"></i>
                <input type="text" 
                       placeholder="Nama Pengguna / ID" 
                       name="username" 
                       required
                       value="{{ old('username') }}"
                       class="@error('username') input-error @enderror"
                       >
            </div>
            
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" 
                       placeholder="Kata Sandi" 
                       name="password" 
                       required
                       class="@error('password') input-error @enderror"
                       >
            </div>

            <div class="forgot-password-link">
                <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
            </div>
            
            <button type="submit">MASUK</button>
        </form>

        <p class="link-text">
            Belum punya akun? 
            <a href="{{ route('register') }}">Daftar Akun Baru</a>
        </p>
    </div>
</body>
</html>