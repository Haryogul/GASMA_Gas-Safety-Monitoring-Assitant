<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk menangani otentikasi
use Illuminate\Http\RedirectResponse; // Untuk mengarahkan pengguna

class LoginController extends Controller
{
    /**
     * Menampilkan halaman/form login.
     * Ini dipanggil oleh Route::get('/').
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Cek apakah pengguna sudah login. Jika ya, arahkan ke dashboard.
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        // Tampilkan view login (misalnya resources/views/auth/login.blade.php)
        return view('auth.login'); 
    }

    /**
     * Memproses percobaan otentikasi (klik tombol "MASUK").
     * Ini dipanggil oleh Route::post('/login').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $credentials = $request->validate([
            // Sesuaikan nama field 'username' atau 'email' sesuai input form Anda.
            // Berdasarkan gambar, kita asumsikan inputnya adalah 'username' atau 'id'
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        // 2. Coba otentikasi
        // Kita menggunakan field 'username' sebagai kunci otentikasi
        if (Auth::attempt($credentials)) {
            // Regenerate session untuk mencegah session fixation
            $request->session()->regenerate();

            // Berhasil login, arahkan ke dashboard
            return redirect()->route('dashboard')->with('success', 'Selamat datang!');
        }

        // 3. Gagal otentikasi
        return back()->withErrors([
            'username' => 'Nama Pengguna atau Kata Sandi yang Anda masukkan salah.',
        ])->onlyInput('username'); // Hanya menyimpan input username sebelumnya
    }

    /**
     * Memproses logout pengguna.
     * Ini dipanggil oleh Route::post('/logout').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        // Logout pengguna
        Auth::logout();

        // Invalidasi sesi saat ini dan regenerate token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login (rute '/')
        return redirect()->route('login')->with('status', 'Anda telah berhasil logout.');
    }
}