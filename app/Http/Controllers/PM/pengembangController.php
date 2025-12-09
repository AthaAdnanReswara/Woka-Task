<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class pengembangController extends Controller
{
    /** ================== TAMPIL DATA ================== */
    public function index()
    {
        $user = Auth::user();

        // Tampilkan developer milik semua PM (bisa ditambah filter created_by bila perlu)
        $pengembang = User::where('role', 'developer')
                          ->with('profile')
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
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'foto'     => 'nullable|image|max:2048',
        ]);

        /** === SIMPAN USER === */
        $pengembang = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'developer',
            'created_by' => Auth::id(),
        ]);

        /** === UPLOAD FOTO === */
        $fotoPath = null;

        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('user_photos', 'public');
        }

        /** === SIMPAN PROFIL === */
        UserProfile::create([
            'user_id' => $pengembang->id,
            'foto'    => $fotoPath,
        ]);

        return redirect()->route('PM.pengembang.index')
                         ->with('success', 'Developer berhasil ditambahkan');
    }

    /** ================== FORM EDIT ================== */
    public function edit(User $pengembang)
    {
        $user = Auth::user();

        // load profile
        $pengembang->load('profile');

        return view('PM.pengembang.edit', compact('user', 'pengembang'));
    }

    /** ================== UPDATE ================== */
    public function update(Request $request, User $pengembang)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email,' . $pengembang->id,
            'password' => 'nullable|min:3',
            'foto'     => 'nullable|image|max:2048'
        ]);

        /** === UPDATE USER === */
        $pengembang->name = $request->name;
        $pengembang->email = $request->email;

        if ($request->filled('password')) {
            $pengembang->password = Hash::make($request->password);
        }

        $pengembang->save();

        /** === UPDATE PROFIL === */
        $profile = $pengembang->profile;

        if (!$profile) {
            $profile = UserProfile::create(['user_id' => $pengembang->id]);
        }

        // Jika upload foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($profile->foto) {
                Storage::disk('public')->delete($profile->foto);
            }

            // Simpan foto baru
            $profile->foto = $request->file('foto')->store('user_photos', 'public');
        }

        $profile->save();

        return redirect()->route('PM.pengembang.index')
                         ->with('success','Data developer berhasil diperbarui');
    }

    /** ================== HAPUS ================== */
    public function destroy(User $pengembang)
    {
        // hapus foto
        if ($pengembang->profile && $pengembang->profile->foto) {
            Storage::disk('public')->delete($pengembang->profile->foto);
        }

        $pengembang->delete();

        return redirect()->route('PM.pengembang.index')
                         ->with('success','Developer berhasil dihapus');
    }
}
