<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $validated = $request->validate(
            [
                'email'    => ['required','email'],
                'password' => ['required'],
            ],
            [
                'email.required'    => 'Email wajib diisi.',
                'email.email'       => 'Format email tidak valid.',
                'password.required' => 'Password wajib diisi.',
            ]
        );
        
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        // Add deleted = 1 condition to authentication
        if (Auth::attempt(array_merge($credentials, ['deleted_at' => null]), $remember)) {
            $request->session()->regenerate();
            // Helper::saveHAction(Auth::guard('web')->user()->id_user, 15, $request->ip());
            return redirect(route('dashboard.index'));
        }

        return back()
        ->with('error', 'Login gagal! Periksa email dan password Anda.')
        ->withInput();
        
    }

    public function dashboard()
    {
        return view('pages.login');
    }

    // ----- LOGOUT -----
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
