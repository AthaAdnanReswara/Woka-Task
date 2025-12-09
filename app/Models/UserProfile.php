<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'user_id',
        'foto',
        'no_hp',
        'alamat',
        'bio',
        'tempat_lahir',
        'tanggal_lahir',
        'gender',
    ];

    // Relasi ke model User (1 profil milik 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
