<?php

namespace App\Http\Controllers\developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\TaskLampiran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PekerjaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil project yang memiliki task milik developer login
        $projects = Project::whereHas('tasks', function ($q) use ($userId) {
            $q->where('assigned_to', $userId);
        })
            ->with(['tasks' => function ($q) use ($userId) {
                $q->where('assigned_to', $userId)
                    ->orderBy('created_at', 'desc');
            }])
            ->get();

        // Format data
        $data = $projects->map(function ($p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description,
                'start_date' => $p->start_date,
                'end_date' => $p->end_date,
                'status' => $p->status,
                'created_by' => $p->creator->name,
                'jumlah_task' => $p->tasks->count(),
                'riwayat' => $p->tasks->map(function ($t) {
                    return [
                        'id' => $t->id,
                        'penanggung_jawab' => $t->user->name,
                        'judul' => $t->judul_task,
                        'kesulitan' => $t->kesulitan,
                        'status' => $t->status,
                        'tanggal_mulai' => $t->tanggal_mulai,
                        'tanggal_selesai' => $t->tanggal_tenggat,
                        'estimasi' => $t->estimasi,
                        'progres' => $t->progress,
                        'pembuat' => $t->creator->name,
                    ];
                })
            ];
        });

        return view('developer.pekerjaan.index', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $userId = Auth::id();

        // Pastikan task milik developer login
        $task = Task::where('id', $id)
            ->where('assigned_to', $userId)
            ->firstOrFail();

        return view('developer.pekerjaan.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();

        $task = Task::where('id', $id)
            ->where('assigned_to', $userId)
            ->firstOrFail();

        $request->validate([
            'deskripsi' => 'nullable',
            'kesulitan' => 'required|in:low,medium,high,critical',
            'status' => 'required|in:rencana,sedang_dikerjakan,selesai,tunda',
            'progress' => 'required|integer|min:0|max:100',
            'lampiran.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi,doc,docx,pdf,zip|max:20480',
        ]);

        $task->update([
            'deskripsi' => $request->deskripsi,
            'kesulitan' => $request->kesulitan,
            'status' => $request->status,
            'progress' => $request->progress,
        ]);

        // === UPLOAD FILE LAMPIRAN ===
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {

                $path = $file->store('task_lampirans', 'public');

                TaskLampiran::create([
                    'task_id' => $task->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'file_size' => $file->getSize(),
                    'uploaded_by' => $userId,
                ]);
            }
        }

        return redirect()->route('developer.pekerjaan.index')
            ->with('success', 'Task berhasil diperbarui');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $userId = Auth::id();

        // Pastikan hanya task milik developer login yang bisa dilihat
        $task = Task::with(['project', 'user', 'creator', 'lampirans'])
            ->where('id', $id)
            ->where('assigned_to', $userId)
            ->firstOrFail();

        return view('developer.pekerjaan.show', compact('task'));
    }

    /**
     * Hapus lampiran task
     */
    public function destroy($id)
    {
        $userId = Auth::id();

        // Ambil lampiran
        $lampiran = TaskLampiran::with('task')
            ->where('id', $id)
            ->firstOrFail();

        // Pastikan lampiran milik task developer login
        if ($lampiran->task->assigned_to != $userId) {
            abort(403, 'Anda tidak memiliki akses menghapus lampiran ini.');
        }

        // Hapus file fisik dari storage
        if ($lampiran->file_path && Storage::disk('public')->exists($lampiran->file_path)) {
            Storage::disk('public')->delete($lampiran->file_path);
        }

        // Hapus record database
        $lampiran->delete();

        return back()->with('success', 'Lampiran berhasil dihapus.');
    }
}
