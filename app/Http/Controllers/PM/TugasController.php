<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_member;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil data project + tasks + user pembuat task
        $data = Project::with(['tasks.user', 'creator'])
            ->orderByDesc('created_at')
            ->get()
            ->map(function ($project) {

                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,

                    // DATE → Carbon → format
                    'start_date' => optional($project->start_date)->format('d M Y'),
                    'end_date' => optional($project->end_date)->format('d M Y'),

                    'status' => $project->status,
                    'created_by' => $project->creator?->name ?? '-',
                    'jumlah_task' => $project->tasks->count(),

                    // === RIWAYAT TASK ===
                    'riwayat' => $project->tasks->map(function ($t) {
                        return [
                            'id' => $t->id,
                            'penanggung_jawab' => $t->user?->name ?? '-',
                            'judul' => $t->judul_task,
                            'deskripsi' => $t->deskripsi,
                            'kesulitan' => $t->kesulitan ?? '-',
                            'status' => $t->status ?? '-',

                            // DATE → Carbon → format
                            'tanggal_mulai' => optional($t->tanggal_mulai)->format('d M Y'),
                            'tanggal_selesai' => optional($t->tanggal_tenggat)->format('d M Y'),

                            'estimasi' => $t->estimasi ?? '-',
                            'progres' => ($t->progress ?? 0) . '%',
                            'pembuat' => $t->creator?->name ?? '-',
                        ];
                    })->values(),
                ];
            });

        return view('PM.tugas.index', compact('data', 'user'));
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
        return view('PM.tugas.tambah', compact('user', 'projects', 'developers'));
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

        return redirect()->route('PM.tugas.index')->with('success', 'Task berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $task = Task::with(['project', 'user', 'creator', 'lampirans'])
            ->findOrFail($id);

        return view('PM.tugas.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $projects = Project::all();
        // ambil user yang berperan developer & terdaftar dalam project
        $developers = User::where('role', 'developer')
            ->whereHas('projects')
            ->get();

        return view('PM.tugas.edit', compact('task',  'projects', 'developers'));
    }

    /**
     * Update the specified resource in storage.
     */
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

        return redirect()->route('PM.tugas.index')->with('success', 'Task berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('PM.tugas.index')->with('success', 'Task berhasil dihapus.');
    }
}
