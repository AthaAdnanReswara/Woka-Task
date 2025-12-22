<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_member;
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
                            'progres' => $t->progress ?? 0,
                            'pembuat' => $t->creator?->name ?? '-',
                        ];
                    })->values(),
                ];
            });

        return view('admin.task.index', compact('data', 'user'));
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

        // 🔥 Jika progress sudah 100% → status otomatis selesai
        $status = $request->progress == 100 ? 'selesai' : $request->status;

        Task::create([
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'judul_task' => $request->judul_task,
            'deskripsi' => $request->deskripsi,
            'kesulitan' => $request->kesulitan,
            'status' => $status,
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
    public function show($id)
    {
        $task = Task::with(['project', 'user', 'creator', 'lampirans'])
            ->findOrFail($id);

        return view('admin.task.show', compact('task'));
    }


    // TAMPILKAN FORM EDIT
    public function edit(Task $task)
    {
        if ($task->status === 'selesai' && $task->progress == 100) {
            return redirect()->back()
                ->with('error', 'Task selesai 100% tidak bisa diubah');
        }

        $user = Auth::user();
        $projects = Project::all();
        $developers = User::where('role', 'developer')->whereHas('projects')->get();

        return view('admin.task.edit', compact('task', 'user', 'projects', 'developers'));
    }


    // UPDATE DATA TASK
    public function update(Request $request, Task $task)
    {
        if ($task->status === 'selesai' && $task->progress == 100) {
            return redirect()->back()
                ->with('error', 'Task selesai 100% tidak bisa diubah');
        }

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

        $status = $request->progress == 100 ? 'selesai' : $request->status;

        $task->update([
            'project_id' => $request->project_id,
            'assigned_to' => $request->assigned_to,
            'judul_task' => $request->judul_task,
            'deskripsi' => $request->deskripsi,
            'kesulitan' => $request->kesulitan,
            'status' => $status,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_tenggat' => $request->tanggal_tenggat,
            'estimasi' => $request->estimasi,
            'progress' => $request->progress,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.task.index')
            ->with('success', 'Task berhasil diperbarui.');
    }

    // HAPUS DATA TASK
    public function destroy(Task $task)
    {
        if ($task->status === 'selesai' && $task->progress == 100) {
            return redirect()->back()
                ->with('error', 'Task selesai 100% tidak bisa dihapus');
        }

        $task->delete();

        return redirect()->route('admin.task.index')->with('success', 'Task berhasil dihapus.');
    }
}
