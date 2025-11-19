// App/Http/Controllers/ForgotPasswordController.php
<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(Request $request)
    {
        // Logika untuk mengirimkan email reset password ke $request->email
        // ...
        return redirect()->back()->with('status', 'Kami telah mengirimkan tautan reset password ke email Anda.');
    }
}