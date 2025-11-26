<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the request data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:3',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success','Selamat Datang Di Dashboard Admin');
            }elseif($user->role === 'PM'){
                return redirect()->route('PM.dashboard')->with('success','Selamat Datang Di Dashboard PM');
            }elseif($user->role === 'developer'){
                return redirect()->route('developer.dashboard')->with('success','Selamat Datang Di Dashboard Developer');
            }else{
                Auth::logout();
                return redirect()->route('login')->withErrors('role pengguna tidak dikenali.');
            }
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
