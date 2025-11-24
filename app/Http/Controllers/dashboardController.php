<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function login() {
        $user = Auth::user();

        if($user->role ==='admin'){
            return view('admin.dashboard',compact('user'));
        }elseif($user->role ==='PM'){
            return view('pm.dashboard',compact('user'));
        }elseif($user->role ==='developer'){
            return view('developer.dashboard', compact('user'));
        }else{
            abort(403, 'Role tidak dikenali.');
        }
    }
}
