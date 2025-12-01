<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $proyek = Project::get();
        return view('PM.proyek.index', compact('user', 'proyek'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        return view('PM.proyek.tambah', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,ongoing,hold,done,cancelled',
        ]);

        Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
        ]);
        return redirect()->route('PM.proyek.index')->with('success', 'selamat berhasil menambah project');
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
    public function edit(Project $proyek)
    {
        $user = Auth::user();
        return view('PM.proyek.edit', compact('user', 'proyek'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $proyek)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:draft,ongoing,hold,done,cancelled',
        ]);
        $proyek->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => $request->status,
            'updated_by' => Auth::user()->id,
        ]);
        return redirect()->route('PM.proyek.index')->with('success', 'selamat anda berhasil mengedit project');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $proyek)
    {
        $proyek->delete();
        return redirect()->route('PM.proyek.index')->with('success', 'selamat anda berhasil menghapus project');
    }
}
