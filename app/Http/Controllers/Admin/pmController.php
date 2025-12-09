<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class PmController extends Controller
{
    /** ================= INDEX ================= **/
    public function index()
    {
        $user = Auth::user();

        $PM = User::where('role', 'PM')
                ->with('profile')
                ->get();

        return view('admin.PM.index', compact('user','PM'));
    }

    /** ================= TAMPIL FORM TAMBAH ================= **/
    public function create()
    {
        $user = Auth::user();

        return view('admin.PM.tambah', compact('user'));
    }

    /** ================= SIMPAN DATA ================= **/
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'foto'     => 'nullable|image|max:2048',
        ]);

        // Simpan user baru
        $PM = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'PM',
        ]);

        /** ==== UPLOAD FOTO ==== **/
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('user_photos', 'public');
        }

        /** ==== SIMPAN PROFILE ==== **/
        UserProfile::create([
            'user_id' => $PM->id,
            'foto' => $fotoPath,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'bio' => $request->bio,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'gender' => $request->gender,
        ]);

        return redirect()->route('admin.PM.index')
                        ->with('success','PM berhasil ditambahkan!');
    }

    /** ================= FORM EDIT ================= **/
    public function edit(User $PM)
    {
        $user = Auth::user();
        $PM->load('profile');

        return view('admin.PM.edit', compact('user','PM'));
    }

    /** ================= UPDATE DATA ================= **/
    public function update(Request $request, User $PM)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $PM->id,
            'password' => 'nullable|min:3',
            'foto'     => 'nullable|image|max:2048',
        ]);

        /** ==== UPDATE DATA USER ==== **/
        $PM->name  = $request->name;
        $PM->email = $request->email;

        if ($request->filled('password')) {
            $PM->password = Hash::make($request->password);
        }
        $PM->save();

        /** ==== UPDATE PROFILE ==== **/
        $profile = $PM->profile;

        // Jika belum ada profil → buat baru
        if (!$profile) {
            $profile = UserProfile::create(['user_id' => $PM->id]);
        }

        // Upload foto baru
        if ($request->hasFile('foto')) {

            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }

            $profile->foto = $request->file('foto')->store('user_photos', 'public');
        }

        // // Update informasi profile lainnya
        // $profile->no_hp         = $request->no_hp;
        // $profile->alamat        = $request->alamat;
        // $profile->bio           = $request->bio;
        // $profile->tempat_lahir  = $request->tempat_lahir;
        // $profile->tanggal_lahir = $request->tanggal_lahir;
        // $profile->gender        = $request->gender;

        $profile->save();

        return redirect()->route('admin.PM.index')->with('success','PM berhasil diperbarui!');
    }

    /** ================= HAPUS DATA ================= **/
    public function destroy(User $PM)
    {
        if ($PM->profile && $PM->profile->foto) {
            Storage::disk('public')->delete($PM->profile->foto);
        }

        $PM->delete();

        return redirect()->route('admin.PM.index')->with('success','PM berhasil dihapus!');
    }
}
