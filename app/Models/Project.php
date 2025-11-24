<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * Relasi:
     * Setiap project dibuat oleh 1 user (Admin atau PM)
     * FK: created_by → users.id
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi:
     * Project bisa diperbarui oleh user lain
     * FK: updated_by → users.id (boleh kosong)
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relasi:
     * 1 Project memiliki banyak Task
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Relasi:
     * Banyak user dapat menjadi anggota dalam 1 project
     * Menggunakan tabel pivot: project_members
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')
                    ->withTimestamps()
                    ->withPivot('role'); // Jika kamu menyimpan role anggota di pivot
    }


}
