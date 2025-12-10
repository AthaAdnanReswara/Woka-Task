<?php

namespace App\Http\Controllers;

use App\Models\Developer;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    public function login()
    {
        $user = Auth::user();

        // ============================
        //            ADMIN
        // ============================
        if ($user->role === 'admin') {

            $totalUser = User::whereIn('role', ['admin', 'PM'])->count();
            $totalProject = Project::count();
            $totalTask = Task::count();
            $totalDeveloper = User::where('role', 'developer')->count();

            $totalAdmin = User::where('role', 'admin')->count();
            $totalPM = User::where('role', 'PM')->count();
            $totalDeveloper = User::where('role', 'developer')->count();

            // Total project dan task
            $totalProject = Project::count();
            $totalTask = Task::count();

            // Ambil semua developer beserta profile
            $developerss = User::where('role', 'developer')->with('profile')->get();

            // 5 user terbaru
            $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();


            // Fix variabel untuk list project
            $totalll = Project::all();

            $tasks = Task::with(['user.profile', 'project'])->get();


            return view('admin.dashboard', compact(
                'user',
                'totalUser',
                'developerss',
                'totalProject',
                'totalTask',
                'totalDeveloper',
                'recentUsers',
                'totalll',
                'totalAdmin',     
                'tasks',     
                'totalPM'          
            ));
        }

        // ============================
        //              PM
        // ============================
        elseif ($user->role === 'PM') {

            $pmId = $user->id;

            $projects = Project::where('created_by', $pmId)->get();
            $tasks = Task::whereIn('project_id', $projects->pluck('id'))->get();

            $developers = User::where('role', 'developer')
                ->whereIn('id', $tasks->pluck('assigned_to')->unique())
                ->get();

            return view('PM.dashboard', [
                'user' => $user,
                'totalUser' => User::where('role', 'PM')->count(),
                'totalProjects' => $projects->count(),
                'totalTasks' => $tasks->count(),
                'totalDevelopers' => $developers->count(),
            ]);
        }

        // ============================
        //           DEVELOPER
        // ============================
        elseif ($user->role === 'developer') {

            return view('developer.dashboard', [
                'user' => $user,
                'totalUsers' => User::count(),
                'totalDevelopers' => User::where('role', 'developer')->count(),
                'totalProjects' => Project::count(),
                'totalTasks' => Task::count(),
                'tasks' => Task::all(),
            ]);
        }

        abort(403, 'Role tidak dikenali.');
    }

    // ============================
    //        TODO CRUD
    // ============================

    public function todoStore(Request $request)
    {
        $request->validate([
            'title' => 'required|min:3',
        ]);

        Todo::create([
            'title' => $request->title,
            'due_date' => $request->due_date,
            'is_done' => false
        ]);

        return back();
    }

    public function todoToggle($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = !$todo->is_done;
        $todo->save();

        return back();
    }

    public function todoDelete($id)
    {
        Todo::findOrFail($id)->delete();
        return back();
    }
}
