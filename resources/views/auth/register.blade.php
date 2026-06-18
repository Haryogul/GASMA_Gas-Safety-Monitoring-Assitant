<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASMA - Daftar Akun Baru</title>
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
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #f5c6cb;
            text-align: left;
            font-size: 14px;
        }
        .input-error {
            border-color: #dc3545 !important;
        }
        input[type="text"], input[type="email"], input[type="password"] {
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
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="logo"><i class="fas fa-plus"></i></div>
        <h2>GASMA</h2>
        <h3>Gas Safety Monitoring Assistant</h3>
        <hr style="border: 0; border-top: 1px solid #eee; margin: 15px 0;">
        <h4>Daftar Akun Baru</h4>

        <!-- Menampilkan semua error validasi dalam satu blok jika ada -->
        @if ($errors->any())
            <div class="alert-error">
                <strong>Pendaftaran gagal!</strong> Silakan periksa kolom yang ditandai merah.
            </div>
        @endif

        <!-- Action form menggunakan named route 'register.post' -->
        <form action="{{ route('register.post') }}" method="POST">
            @csrf <!-- Wajib untuk keamanan Laravel -->
            
            <!-- Input Nama Lengkap -->
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" 
                       placeholder="Nama Lengkap" 
                       name="nama_lengkap" 
                       required
                       value="{{ old('nama_lengkap') }}"
                       class="@error('nama_lengkap') input-error @enderror"
                       >
            </div>
            @error('nama_lengkap')<small class="alert-error">{{ $message }}</small>@enderror

            <!-- Input Nama Pengguna / ID -->
            <div class="input-group">
                <i class="fas fa-user-tag"></i>
                <input type="text" 
                       placeholder="Nama Pengguna / ID" 
                       name="nama_pengguna" 
                       required
                       value="{{ old('nama_pengguna') }}"
                       class="@error('nama_pengguna') input-error @enderror"
                       >
            </div>
            @error('nama_pengguna')<small class="alert-error">{{ $message }}</small>@enderror

            <!-- Input Alamat Email -->
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" 
                       placeholder="Alamat Email" 
                       name="email" 
                       required
                       value="{{ old('email') }}"
                       class="@error('email') input-error @enderror"
                       >
            </div>
            @error('email')<small class="alert-error">{{ $message }}</small>@enderror

            <!-- Input Kata Sandi -->
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" 
                       placeholder="Kata Sandi" 
                       name="password" 
                       required
                       class="@error('password') input-error @enderror"
                       >
            </div>
            @error('password')<small class="alert-error">{{ $message }}</small>@enderror
            
            <!-- Input Konfirmasi Kata Sandi -->
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" 
                       placeholder="Konfirmasi Kata Sandi" 
                       name="password_confirmation" 
                       required
                       class="@error('password_confirmation') input-error @enderror"
                       >
            </div>
            <!-- Pesan error untuk password_confirmation sudah dicakup oleh error 'password' karena rule 'confirmed' -->

            <!-- Tombol DAFTAR -->
            <button type="submit">DAFTAR</button>
        </form>

        <!-- Tautan menggunakan named route 'login' -->
        <p class="link-text">
            Sudah punya akun? 
            <a href="{{ route('login') }}">Masuk</a>
        </p>
    </div>
</body>
</html>