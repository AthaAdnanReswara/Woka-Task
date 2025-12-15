<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserProfile $userProfile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserProfile $userProfile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // Validasi
        $request->validate([
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'no_hp'          => 'nullable|string|max:20',
            'gender'         => 'nullable|in:laki-laki,perempuan,tidak diketaui',
            'tempat_lahir'   => 'nullable|string|max:255',
            'tanggal_lahir'  => 'nullable|date',
            'alamat'         => 'nullable|string',
            'bio'            => 'nullable|string',
        ]);

        $user = Auth::user();

        // Ambil profile atau buat baru jika belum ada
        $profile = UserProfile::firstOrCreate(
            ['user_id' => $user->id]
        );

        // ===============================
        // Upload Foto
        // ===============================
        if ($request->hasFile('foto')) {

            // Hapus foto lama jika ada
            if ($profile->foto && Storage::disk('public')->exists($profile->foto)) {
                Storage::disk('public')->delete($profile->foto);
            }

            // Simpan foto baru
            $fotoPath = $request->file('foto')->store('profile', 'public');
            $profile->foto = $fotoPath;
        }

        // ===============================
        // Update Data Profile
        // ===============================
        $profile->no_hp         = $request->no_hp;
        $profile->gender        = $request->gender;
        $profile->tempat_lahir  = $request->tempat_lahir;
        $profile->tanggal_lahir = $request->tanggal_lahir;
        $profile->alamat        = $request->alamat;
        $profile->bio           = $request->bio;

        $profile->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserProfile $userProfile)
    {
        //
    }
}
