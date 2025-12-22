<?php

namespace App\Http\Controllers\PM;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\Project_member;
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

        // SESUAI BLADE: $members as $member
        $pengembang = User::where('role', 'developer')
            ->with('profile')->get();

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
        $user = Auth::user();
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3',
            'foto'     => 'nullable|image|max:2048',
        ]);

        $pengembang = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => 'developer',
            'created_by' => $user->id,
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('user_photos', 'public');
        }

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
            'foto'     => 'nullable|image|max:2048',
        ]);

        /** ================= UPDATE DATA USER ================= **/
        $pengembang->name  = $request->name;
        $pengembang->email = $request->email;

        if ($request->filled('password')) {
            $pengembang->password = Hash::make($request->password);
        }

        $pengembang->save();


        /** ================= UPDATE DATA PROFILE ================= **/

        // Ambil profile
        $profile = $pengembang->profile;

        // Jika profile tidak ada → buat baru
        if (!$profile) {
            $profile = UserProfile::create([
                'user_id' => $pengembang->id
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


        return redirect()->route('PM.pengembang.index')
            ->with('success', 'Developer berhasil diperbarui!');
    }

    /** ================== HAPUS ================== */
    public function destroy(User $pengembang)
    {
        if ($pengembang->profile && $pengembang->profile->foto) {
            Storage::disk('public')->delete($pengembang->profile->foto);
        }

        $pengembang->delete();

        return redirect()->route('PM.pengembang.index')
            ->with('success', 'Developer berhasil dihapus');
    }
}
