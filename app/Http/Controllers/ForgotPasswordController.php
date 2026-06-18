<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Langkah 1: Memproses pengiriman permintaan reset (Simulasi Email)
     */
    public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email|exists:users,email']);

    $token = Str::random(60);

    DB::table('password_reset_tokens')->updateOrInsert(
        ['email' => $request->email],
        ['token' => $token, 'created_at' => now()]
    );

    // Pastikan rute 'password.reset' sudah didefinisikan di web.php
    return redirect()->route('password.reset', ['token' => $token])
                     ->with('status', 'Silahkan masukkan kata sandi baru.');
}

    /**
     * Langkah 2: Memproses update password baru
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:5|confirmed',
            'token' => 'required'
        ], [
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Kata sandi berhasil diperbarui!');
    }
}