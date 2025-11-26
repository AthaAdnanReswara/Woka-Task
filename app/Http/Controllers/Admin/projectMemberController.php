<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Project_member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class projectMemberController extends Controller
{
    /**
     * Menampilkan semua member dalam 1 project
     */
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $projects = Project::all();
        $projectMembers = Project_member::all();

        return view('Admin.projectMember.index', compact('user', 'users', 'projects', 'projectMembers'));
    }


    /**
     * Form tambah member ke project
     */
    public function create()
    {
        $projects = Project::all();
        $user = Auth::user();
        $users = User::all();

        return view('admin.projectMember.tambah', compact('projects', 'user', 'users'));
    }


    /**
     * Simpan user baru sebagai member project
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

        return redirect()->route('admin.projectMember.index')->with('success', 'Member berhasil ditambahkan');
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
// ================== EDIT ==================
    public function edit(Project_member $project_member)
    {
        $user = Auth::user();

        $projectMember  = Project_member::findOrFail($project_member->id);
        $users   = User::all();
        $projects = Project::all();

        return view('admin.projectMember.edit', compact('user','projectMember','users','projects'));
    }


    // ================== UPDATE ==================
    public function update(Request $request,Project_member $project_member)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'user_id'    => 'required|exists:users,id',
        ]);

        $project_member = Project_member::findOrFail($project_member->id);

        // Cek duplicate saat update (berbeda ID)
        $exists = Project_member::where('project_id',$request->project_id)
                                ->where('user_id',$request->user_id)
                                ->where('id','!=',$project_member->id)
                                ->exists();

        if($exists){
            return back()->with('error','User sudah terdaftar pada project ini!');
        }

        $project_member->update([
            'project_id' => $request->project_id,
            'user_id'    => $request->user_id
        ]);

        return redirect()->route('admin.projectMember.index')->with('success','Member berhasil diupdate');
    }


    // ================== DELETE ==================
    public function destroy(Project_member $project_member)
    {
        $project_member = Project_member::findOrFail($project_member->id);
        $project_member->delete();

        return redirect()->back()->with('success','Member berhasil dihapus');
    }
}

