<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $projects = Project::all();
        $members = Project_member::all();

        return view('PM.anggota.index', compact('user', 'users', 'projects', 'members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $user = Auth::user();
        $users = User::all();

        return view('PM.anggota.tambah', compact('projects', 'user', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $project_id = $request->project_id;

        // cek duplicate
        $exists = Project_member::where('project_id', $project_id)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'User sudah terdaftar dalam project ini');
        }

        Project_member::create([
            'project_id' => $project_id,
            'user_id' => $request->user_id
        ]);

        return redirect()->route('PM.anggota.index')->with('success', 'Member berhasil ditambahkan');
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
        $member  = Project_member::findOrFail($id);
        $users   = User::all();
        $projects = Project::all();

        return view('PM.anggota.edit', compact('user','member','users','projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
        ]);

        $project_member = Project_member::findOrFail($id);

        // Cek duplicate saat update (berbeda ID)
        $exists = Project_member::
                                where('user_id',$request->user_id)
                                ->where('id','!=',$project_member->id)
                                ->exists();

        if($exists){
            return back()->with('error','User sudah terdaftar pada project ini!');
        }

        $project_member->update([
            'user_id'    => $request->user_id
        ]);

        return redirect()->route('PM.anggota.index')->with('success','Member berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $project_member = Project_member::findOrFail($id);
        $project_member->delete();

        return redirect()->back()->with('success','Member berhasil dihapus');
    }
}
