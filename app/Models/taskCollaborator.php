<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class taskCollaborator extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
    ];

    /**
     * Kolaborator milik task tertentu
     */
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }

    /**
     * User (developer / pm / admin) yang menjadi kolaborator task
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
