<?php

namespace App\Http\Controllers;

use App\Models\User; // Pastikan model User sudah diimport
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Untuk mengenkripsi kata sandi
use Illuminate\Http\RedirectResponse; 
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Menampilkan halaman/form pendaftaran.
     * Ini dipanggil oleh Route::get('/register').
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        // Tampilkan view register (misalnya resources/views/auth/register.blade.php)
        return view('auth.register'); 
    }

    /**
     * Memproses data form pendaftaran dan menyimpan pengguna baru.
     * Ini dipanggil oleh Route::post('/register').
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi Input
        $validatedData = $request->validate([
            // Berdasarkan gambar form pendaftaran:
            'nama_lengkap' => 'required|max:255',
            'nama_pengguna' => 'required|unique:users,username|min:4|max:20', // Harus unik di tabel 'users'
            'email' => 'required|email:dns|unique:users', // Harus unik dan format email valid
            'password' => 'required|min:5|confirmed', // 'confirmed' akan otomatis mencari field 'password_confirmation'
        ], [
            // Custom pesan kesalahan (opsional)
            'nama_pengguna.unique' => 'Nama Pengguna sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi Kata Sandi tidak cocok.',
        ]);

        // 2. Hash Kata Sandi (Enkripsi)
        // Kata sandi harus dienkripsi sebelum disimpan ke database
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        // Asumsi field 'nama_pengguna' di form Anda sesuai dengan field 'username' di tabel users
        // Jika di tabel database namanya 'name', lakukan penyesuaian:
        $validatedData['name'] = $validatedData['nama_lengkap']; 
        $validatedData['username'] = $validatedData['nama_pengguna'];
        
        // Hapus field yang tidak diperlukan di model User
        unset($validatedData['nama_lengkap']);
        unset($validatedData['nama_pengguna']);
        unset($validatedData['password_confirmation']); // Field ini hanya untuk validasi

        // 3. Simpan Pengguna Baru
        User::create($validatedData);

        // 4. Redirect ke Halaman Login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Pendaftaran akun berhasil! Silahkan masuk.');
    }
}