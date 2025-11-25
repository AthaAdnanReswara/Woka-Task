<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function login() {
        $user = Auth::user();

        if($user->role ==='admin'){
            $totalUser = User::whereIn('role', ['admin', 'PM'])->count();
            $totalProject = Project::count();
            $totalTask = Task::count();
            $totalDeveloper = User::where('role', 'developer')->count();
            return view('admin.dashboard',compact('user','totalUser','totalProject','totalTask','totalDeveloper'));
        }elseif($user->role ==='PM'){
            return view('pm.dashboard',compact('user'));
        }elseif($user->role ==='developer'){
            return view('developer.dashboard', compact('user'));
        }else{
            abort(403, 'Role tidak dikenali.');
        }
    }
}
