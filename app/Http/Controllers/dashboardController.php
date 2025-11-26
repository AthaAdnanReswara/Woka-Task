<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalUser = User::whereIn('role', ['admin', 'PM'])->count();
            $totalProject = Project::count();
            $totalTask = Task::count();
            $totalDeveloper = User::where('role', 'developer')->count();
            return view('admin.dashboard', compact('user', 'totalUser', 'totalProject', 'totalTask', 'totalDeveloper'));
        } elseif ($user->role === 'PM') {
            $pmId = $user->id;
            // Ambil project yang dibuat oleh PM login
            $projects = Project::where('created_by', $pmId)->get();
            // Ambil tasks yang terkait dengan projects PM
            $tasks = Task::whereIn('project_id', $projects->pluck('id'))->get();
            // Ambil developers berdasarkan assigned_to di task
            $developers = User::where('role', 'developer')->whereIn('id', $tasks->pluck('assigned_to')->unique())->get();
            // Summary
            $totalProjects = $projects->count();
            $totalTasks = $tasks->count();
            $totalDevelopers = $developers->count();
            $totalUser = User::where('role', 'PM')->count();
            return view('PM.dashboard', compact('user', 'totalUser','totalProjects','totalTasks','totalDevelopers'));
        } elseif ($user->role === 'developer') {
            return view('developer.dashboard', compact('user'));
        } else {
            abort(403, 'Role tidak dikenali.');
        }
    }
}
