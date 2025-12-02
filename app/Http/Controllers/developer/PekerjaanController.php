<?php

namespace App\Http\Controllers\developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Developer hanya melihat task yang dia tangani
        $tasks = Task::with(['project', 'creator'])
            ->where('assigned_to', $user->id)
            ->get();

        // Kita susun data seperti di Blade kamu
        $data = $tasks->groupBy('project_id')->map(function($tasks, $projectId) {
            $project = $tasks->first()->project;
            return [
                'id' => $project->id,
                'name' => $project->name,
                'description' => $project->description,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'status' => $project->status,
                'created_by' => $project->creator->name ?? '-',
                'jumlah_task' => $tasks->count(),
                'riwayat' => $tasks->map(function($task) {
                    return [
                        'id' => $task->id,
                        'penanggung_jawab' => $task->user->name ?? '-',
                        'judul' => $task->judul_task,
                        'deskripsi' => $task->deskripsi,
                        'kesulitan' => $task->kesulitan,
                        'status' => $task->status,
                        'tanggal_mulai' => $task->tanggal_mulai?->format('Y-m-d'),
                        'tanggal_selesai' => $task->tanggal_tenggat?->format('Y-m-d'),
                        'estimasi' => $task->estimasi,
                        'progres' => $task->progress,
                        'pembuat' => $task->creator->name ?? '-',
                    ];
                })->toArray(),
            ];
        })->values()->toArray();

        return view('developer.pekerjaan.index', compact('data'));
    }

    public function edit(Task $task)
    {
        $user = Auth::user();

        if ($task->assigned_to !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit task ini.');
        }

        return view('developer.pekerjaan.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $user = Auth::user();

        if ($task->assigned_to !== $user->id) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate task ini.');
        }

        $validated = $request->validate([
            'status' => 'required|in:rencana,sedang_dikerjakan,tinjauan,selesai,dibatalkan',
            'progress' => 'nullable|integer|min:0|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $task->update(array_merge($validated, [
            'updated_by' => $user->id,
        ]));

        return redirect()->route('developer.pekerjaan.index')
            ->with('success', 'Task berhasil diperbarui.');
    }
}
