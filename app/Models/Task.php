<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'project_id',
        'assigned_to',
        'judul_task',
        'deskripsi',
        'kesulitan',
        'status',
        'tanggal_mulai',
        'tanggal_tenggat',
        'estimasi',
        'progress',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_tenggat' => 'date',
    ];

    /**
     * Relasi:
     * Task milik 1 project
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * Relasi:
     * Task dikerjakan oleh 1 Developer (PIC)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Relasi:
     * Task dibuat oleh 1 user (Admin/PM)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relasi:
     * Task diperbarui terakhir oleh user lain
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Relasi:
     * Task memiliki banyak lampiran file
     */
    public function attachments()
    {
        return $this->hasMany(TaskLampiran::class, 'task_id');
    }

    /**
     * Relasi:
     * Task memiliki banyak kolaborator (user)
     */
    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_collaborators', 'task_id', 'user_id')
            ->withTimestamps();
    }
}
