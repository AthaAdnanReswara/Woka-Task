<?php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DeveloperProjectController extends Controller
{
    // Menampilkan semua project yang developer ikuti

    public function index()
    {
        $user = Auth::user();
        $projects = Project::whereHas('members', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with('members', 'tasks')->get();

        return view('developer.project.index', compact('projects'));
    }


    // Menampilkan detail project
public function show($id)
{
    $user = Auth::user();
    $project = Project::with('members', 'tasks.assignedTo', 'tasks.attachments')
                      ->whereHas('members', function($q) use ($user) {
                          $q->where('user_id', $user->id);
                      })
                      ->findOrFail($id);

    return view('developer.project.show', compact('project'));
}


    // Developer tidak perlu create, store, edit, update, destroy
    // jadi kita bisa kosongkan method-method berikut jika mau
    public function create()
    {
        abort(403);
    }
    public function store(Request $request)
    {
        abort(403);
    }
    public function edit($id)
    {
        abort(403);
    }
    public function update(Request $request, $id)
    {
        abort(403);
    }
    public function destroy($id)
    {
        abort(403);
    }
}
