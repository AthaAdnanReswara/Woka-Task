<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $projects = Project::with(['tasks.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.task.index', compact('user', 'projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $projects = Project::all();
        $developers = User::where('role', 'developer')
            ->whereHas('projects') // hanya ambil user yg terdaftar di project_members
            ->get();
        return view('admin.task.tambah', compact('user', 'projects', 'developers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'judul_task' => 'required|string|max:255',
            'deskripsi' => 'nullable',
            'kesulitan' => 'nullable|in:low,medium,high,critical',
            'status' => 'required|in:rencana,sedang_dikerjakan,tinjauan,selesai,dibatalkan',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_tenggat' => 'nullable|date|after_or_equal:tanggal_mulai',
            'estimasi' => 'nullable|numeric',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        Task::create([
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'judul_task' => $request->judul_task,
            'deskripsi' => $request->deskripsi,
            'kesulitan' => $request->kesulitan,
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_tenggat' => $request->tanggal_tenggat,
            'estimasi' => $request->estimasi,
            'progress' => $request->progress ?? 0,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('admin.task.index')->with('success', 'Task berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    // TAMPILKAN FORM EDIT
    public function edit(Task $task)
    {
        $user = Auth::user();
        $projects = Project::all();
        // ambil user yang berperan developer & terdaftar dalam project
        $developers = User::where('role', 'developer')
            ->whereHas('projects')
            ->get();

        return view('admin.task.edit', compact('task', 'user', 'projects', 'developers'));
    }


    // UPDATE DATA TASK
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'assigned_to' => 'required|exists:users,id',
            'judul_task' => 'required|string|max:255',
            'deskripsi' => 'nullable',
            'kesulitan' => 'nullable|in:low,medium,high,critical',
            'status' => 'required|in:rencana,sedang_dikerjakan,tinjauan,selesai,dibatalkan',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_tenggat' => 'nullable|date|after_or_equal:tanggal_mulai',
            'estimasi' => 'nullable|numeric',
            'progress' => 'required|integer|min:0|max:100',
        ]);

        $task->update([
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'judul_task' => $request->judul_task,
            'deskripsi' => $request->deskripsi,
            'kesulitan' => $request->kesulitan,
            'status' => $request->status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_tenggat' => $request->tanggal_tenggat,
            'estimasi' => $request->estimasi,
            'progress' => $request->progress,
            'updated_by' => Auth::id()
        ]);

        return redirect()->route('admin.task.index')->with('success', 'Task berhasil diperbarui.');
    }


    // HAPUS DATA TASK
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('admin.task.index')->with('success', 'Task berhasil dihapus.');
    }
}
