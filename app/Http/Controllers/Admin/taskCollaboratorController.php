<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\taskCollaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class taskCollaboratorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $collabs = taskCollaborator::with(['task', 'user'])->get();
        return view('admin.collaborator.index', compact('user', 'collabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $tasks = Task::all();
        $users = User::all();
        return view('admin.collaborator.tambah', compact('user','tasks', 'users'));
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id'
        ]);

        // Cek apakah sudah ada
        $exists = taskCollaborator::where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists)
            return back()->with('error', 'User sudah terdaftar sebagai collaborator dalam task ini.');

        taskCollaborator::create([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.collaborator.index')->with('success', 'Collaborator berhasil ditambahkan.');
    }

    /**
     * Show the form for editing.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $collab = taskCollaborator::findOrFail($id);
        $tasks = Task::all();
        $users = User::all();

        return view('admin.collaborator.edit', compact('user','collab', 'tasks', 'users'));
    }

    /**
     * Update data collaborator.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $collab = taskCollaborator::findOrFail($id);

        // Cek jika user & task sama supaya tidak double
        $exists = taskCollaborator::where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists)
            return back()->with('error', 'Collaborator ini sudah terdaftar pada task tersebut.');

        $collab->update([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('admin.collaborator.index')->with('success', 'Collaborator berhasil diperbarui.');
    }

    /**
     * Delete collaborator.
     */
    public function destroy($id)
    {
        $collab = taskCollaborator::findOrFail($id);
        $collab->delete();

        return redirect()->route('admin.collaborator.index')->with('success', 'Collaborator berhasil dihapus.');
    }
}
