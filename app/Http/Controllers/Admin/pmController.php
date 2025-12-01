<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class pmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $PM = User::where('role', 'PM')->get();
        return view('admin.PM.index', compact('user','PM'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        return view('admin.PM.tambah', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required',
            'email'=> 'required|string|email|unique:users,email',
            'password' =>'required|min:3',
        ]);
        User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' => Hash::make($request->password),
            'role' => 'PM',
        ]);

        return redirect()->route('admin.PM.index')->with('success','Selamat berhasil menambah user PM');
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
    public function edit(User $PM)
    {
        $user = Auth::user();
        return view('admin.PM.edit', compact('user','PM'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $PM)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email,' .$PM->id,
            'password' => 'nullable|min:3,'
        ]);

        $PM->name = $request->name;
        $PM->email = $request->email;

        if($request->filled('password')) {
            $PM->password = Hash::make($request->password);
        }

        $PM->save();
        return redirect()->route('admin.PM.index')->with('success','Selamat Berhasil Mengganti USer PM');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $PM)
    {
        $PM->delete();
        return redirect()->route('admin.PM.index')->with('success','Selamat Berhasil Mengapus PM');
    }
}
