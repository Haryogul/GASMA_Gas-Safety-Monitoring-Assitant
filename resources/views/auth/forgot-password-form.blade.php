<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - GASMA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #1e293b; /* Warna latar belakang gelap dari sidebar */
        }
    </style>
</head>
<body>

<div class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">
        
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pemulihan Kata Sandi</h1>
            <p class="text-gray-500">Masukkan alamat email Anda untuk menerima tautan *reset password*.</p>
        </div>
        
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        @endif

        @error('email')
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ $message }}</span>
            </div>
        @enderror
        
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400 text-sm"></i>
                    </div>
                    <input id="email" name="email" type="email" required autofocus 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-cyan-500 focus:border-cyan-500" 
                           placeholder="contoh@domain.com" value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <button type="submit" 
                        class="w-full flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-cyan-500 transition duration-300">
                    <i class="fas fa-paper-plane text-sm"></i> Kirim Tautan Pemulihan
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-cyan-600 hover:text-cyan-800 hover:underline">
                Kembali ke Halaman Login
            </a>
        </div>
    </div>
</div>

</body>
</html>