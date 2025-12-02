<?php

namespace App\Http\Controllers\developer;

use App\Http\Controllers\Controller;
use App\Models\Project;
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
                            'judul' => $t->title,
                            'deskripsi' => $t->description,
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

        return view('developer.pekerjaan.index', compact('data', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
