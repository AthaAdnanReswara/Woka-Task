<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DeveloperController extends Controller
{
    /** =============== TAMPIL DATA =============== **/
    public function index()
    {
        $user = Auth::user();

        $developer = User::where('role', 'developer')
                        ->with('profile')->get();

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
            'foto'     => 'nullable|image|max:2048', // JPG/PNG
        ]);
        // Simpan user
        $developer = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'developer',
            'created_by' => $user->id,
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('user_photos', 'public');
        }

        // Simpan ke user_profiles
        UserProfile::create([
            'user_id'       => $developer->id,
            'foto'          => $fotoPath,
            'no_hp'         => $request->no_hp,
            'alamat'        => $request->alamat,
            'bio'           => $request->bio,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender'        => $request->gender,
        ]);

        return redirect()->route('admin.developer.index')
                         ->with('success', 'Developer berhasil ditambahkan!');
    }

    /** =============== EDIT =============== **/
    public function edit(User $developer)
    {
        $user = Auth::user();

        // Ambil profile developer
        $developer->load('profile');

        return view('admin.developer.edit', compact('user','developer'));
    }

    /** =============== UPDATE DATA =============== **/
    public function update(Request $request, User $developer)
{
    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users,email,' . $developer->id,
        'password' => 'nullable|min:3',
        'foto'     => 'nullable|image|max:2048',
    ]);

    /** ================= UPDATE DATA USER ================= **/
    $developer->name  = $request->name;
    $developer->email = $request->email;

    if ($request->filled('password')) {
        $developer->password = Hash::make($request->password);
    }

    $developer->save();


    /** ================= UPDATE DATA PROFILE ================= **/

    // Ambil profile
    $profile = $developer->profile;

    // Jika profile tidak ada → buat baru
    if (!$profile) {
        $profile = UserProfile::create([
            'user_id' => $developer->id
        ]);
    }

    // Upload foto baru
    if ($request->hasFile('foto')) {

        // Hapus foto lama jika ada
        if ($profile->foto) {
            Storage::disk('public')->delete($profile->foto);
        }

        $profile->foto = $request->file('foto')->store('user_photos', 'public');
    }

    // // Update data lain
    // $profile->no_hp         = $request->no_hp;
    // $profile->alamat        = $request->alamat;
    // $profile->bio           = $request->bio;
    // $profile->tempat_lahir  = $request->tempat_lahir;
    // $profile->tanggal_lahir = $request->tanggal_lahir;
    // $profile->gender        = $request->gender;

    $profile->save();


    return redirect()->route('admin.developer.index')
                     ->with('success','Developer berhasil diperbarui!');
}


    /** =============== HAPUS =============== **/
    public function destroy(User $developer)
    {
        // Hapus foto dulu
        if ($developer->profile && $developer->profile->foto) {
            Storage::disk('public')->delete($developer->profile->foto);
        }

        // Hapus user (+ profil otomatis karena cascade)
        $developer->delete();

        return redirect()->route('admin.developer.index')
                         ->with('success','Developer berhasil dihapus!');
    }
}
