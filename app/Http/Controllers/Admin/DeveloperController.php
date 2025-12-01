<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeveloperController extends Controller
{
    /** =============== TAMPIL DATA =============== **/
    public function index()
    {
        $user = Auth::user();

        // Hanya tampilkan developer yang dibuat oleh user login
        $developer = User::where('role', 'developer')->get();

        return view('admin.developer.index', compact('user', 'developer'));
    }

    /** =============== HALAMAN TAMBAH =============== **/
    public function create()
    {
        $user = Auth::user();
        return view('admin.developer.tambah', compact('user'));
    }

    /** =============== SIMPAN DATA =============== **/
    public function store(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'developer',
            'created_by' => $user->id,  // <── wajib agar bisa difilter
        ]);

        return redirect()->route('admin.developer.index')
                         ->with('success', 'Developer berhasil ditambahkan!');
    }

    /** =============== EDIT =============== **/
    public function edit(User $developer)
    {
        $user = Auth::user();
        return view('admin.developer.edit', compact('user','developer'));
    }

    /** =============== UPDATE DATA =============== **/
    public function update(Request $request, User $developer)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $developer->id,
            'password' => 'nullable|min:3',
        ]);

        $developer->name  = $request->name;
        $developer->email = $request->email;

        if($request->filled('password')){
            $developer->password = Hash::make($request->password);
        }

        $developer->save();

        return redirect()->route('admin.developer.index')
                         ->with('success','Developer berhasil diperbarui!');
    }

    /** =============== HAPUS =============== **/
    public function destroy(User $developer)
    {
        $developer->delete();
        return redirect()->route('admin.developer.index')
                         ->with('success','Developer berhasil dihapus!');
    }
}
