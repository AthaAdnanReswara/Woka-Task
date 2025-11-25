<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskLampiran extends Model
{
    protected $fillable = [
        'task_id',
        'file_path',
        'file_name',
        'file_size',
        'uploaded_by',
    ];

    /**
     * Relasi:
     * Lampiran hanya milik 1 task
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * Relasi:
     * Lampiran diunggah oleh 1 user
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
