<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\taskCollaborator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelompokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $collabs = taskCollaborator::with(['task', 'user'])->get();
        return view('PM.kelompok.index', compact('user', 'collabs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $tasks = Task::all();
        $users = User::all();
        return view('PM.kelompok.tambah', compact('user', 'tasks', 'users'));
    }

    /**
     * Store a newly created resource in storage.
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

        return redirect()->route('PM.kelompok.index')->with('success', 'Collaborator berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $kelompok = taskCollaborator::findOrFail($id);
        $tasks = Task::all();
        $users = User::all();

        return view('PM.kelompok.edit', compact('user', 'kelompok', 'tasks', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id'
        ]);

        $kelompok = taskCollaborator::findOrFail($id);

        // Cek jika user & task sama supaya tidak double
        $exists = taskCollaborator::where('task_id', $request->task_id)
            ->where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists)
            return back()->with('error', 'Collaborator ini sudah terdaftar pada task tersebut.');

        $kelompok->update([
            'task_id' => $request->task_id,
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('PM.kelompok.index')->with('success', 'Collaborator berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $collab = taskCollaborator::findOrFail($id);
        $collab->delete();

        return redirect()->route('PM.kelompok.index')->with('success', 'Collaborator berhasil dihapus.');
    }
}
