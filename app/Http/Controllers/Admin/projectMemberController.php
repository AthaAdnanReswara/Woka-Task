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
        $members = Project_member::all();

        return view('Admin.member.index', compact('user', 'users', 'projects', 'members'));
    }


    /**
     * Form tambah member ke project
     */
    public function create()
    {
        $projects = Project::all();
        $user = Auth::user();
        $users = User::all();

        return view('admin.member.tambah', compact('projects', 'user', 'users'));
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

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil ditambahkan');
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
    public function edit($id)
    {
        $user = Auth::user();
        $member  = Project_member::findOrFail($id);
        $users   = User::all();
        $projects = Project::all();

        return view('admin.member.edit', compact('user','member','users','projects'));
    }

    // ================== UPDATE ==================
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

        return redirect()->route('admin.member.index')->with('success','Member berhasil diupdate');
    }


    // ================== DELETE ==================
    public function destroy($id)
    {
        $project_member = Project_member::findOrFail($id);
        $project_member->delete();

        return redirect()->back()->with('success','Member berhasil dihapus');
    }
}

