<?php

namespace App\Http\Controllers\developer;

use App\Http\Controllers\Controller;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class BiodataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Jika profile belum ada, dibuat otomatis
        $profile = UserProfile::firstOrCreate([
            'user_id' => $user->id
        ]);

        return view('developer.biodata.index', compact('user', 'profile'));
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            // USER TABLE
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',

            // Password opsional
            'password' => 'nullable|min:6|confirmed',

            // PROFILE TABLE
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'bio' => 'nullable|string',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',

            // "tidak diketaui" harus sesuai database
            'gender' => 'nullable|string|in:laki-laki,perempuan,tidak diketaui',
        ]);

        /* -------------------------
        | UPDATE USER TABLE
        ------------------------- */
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password jika ada input
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();


        /* -------------------------
        | UPDATE PROFILE TABLE
        ------------------------- */
        $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);

        // Handle foto upload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($profile->foto && Storage::exists('public/' . $profile->foto)) {
                Storage::delete('public/' . $profile->foto);
            }

            // Simpan foto baru
            $profile->foto = $request->file('foto')->store('profile', 'public');
        }

        // Update field lainnya
        $profile->no_hp = $request->no_hp;
        $profile->alamat = $request->alamat;
        $profile->bio = $request->bio;
        $profile->tempat_lahir = $request->tempat_lahir;
        $profile->tanggal_lahir = $request->tanggal_lahir;
        $profile->gender = $request->gender;
        $profile->save();

        return redirect()->route('developer.biodata.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
