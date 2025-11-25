<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DeveloperController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $developer = User::where('role', 'developer')->get();
        return view('admin.developer.index', compact('user', 'developer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        return view('admin.developer.tambah', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|min:3',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'developer'
        ]);
        return redirect()->route('admin.developer.index')->with('success', 'selamat anda berhasil menambah developer');
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
    public function edit(User $developer)
    {
        $user = Auth::user();
        return view('admin.developer.edit', compact('user','developer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $developer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' .$developer->id,
            'password' => 'nullable|min:3,'
        ]);

        $developer->name = $request->name;
        $developer->email = $request->email;

        if($request->filled('password')) {
            $developer->password = Hash::make($request->password);
        }

        $developer->save();
        return redirect()->route('admin.developer.index')->with('success','Selamat Berhasil Mengganti USer developer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $developer)
    {
        $developer->delete();
        return redirect()->route('admin.developer.index')->with('success','selamat adnda berasil menghapus developer');
    }
}
