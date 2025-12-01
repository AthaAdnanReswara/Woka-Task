<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class pengembangController extends Controller
{
    /** ================== TAMPIL DATA ================== */
    public function index()
    {
        $user = Auth::user();

        // Hanya tampilkan developer yang dibuat oleh PM login
        $pengembang = User::where('role', 'developer')
                          ->where('created_by', $user->id)
                          ->get();

        return view('PM.pengembang.index', compact('user', 'pengembang'));
    }

    /** ================== FORM TAMBAH ================== */
    public function create()
    {
        $user = Auth::user();
        return view('PM.pengembang.tambah', compact('user'));
    }

    /** ================== SIMPAN DATA ================== */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'developer',
            'created_by' => Auth::id(), // <===== penting!
        ]);

        return redirect()->route('PM.pengembang.index')
                         ->with('success', 'Developer berhasil ditambahkan');
    }

    /** ================== EDIT ================== */
    public function edit(User $pengembang)
    {
        $user = Auth::user();
        return view('PM.pengembang.edit', compact('user', 'pengembang'));
    }

    /** ================== UPDATE ================== */
    public function update(Request $request, User $pengembang)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email,' . $pengembang->id,
            'password' => 'nullable|min:3',
        ]);

        $pengembang->name  = $request->name;
        $pengembang->email = $request->email;

        if ($request->filled('password')) {
            $pengembang->password = Hash::make($request->password);
        }

        $pengembang->save();

        return redirect()->route('PM.pengembang.index')
                         ->with('success','Data developer berhasil diperbarui');
    }

    /** ================== HAPUS ================== */
    public function destroy(User $pengembang)
    {
        $pengembang->delete();
        return redirect()->route('PM.pengembang.index')->with('success','Developer berhasil dihapus');
    }
}
