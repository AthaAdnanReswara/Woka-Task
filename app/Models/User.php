<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    //ini relasi dari migration Project
    public function createdProject(){
        return $this->hasMany(Project::class,'created_by');
    }
    public function updatedProject(){
        return $this->hasMany(Project::class,'updated_by');
    }

    //ini relasi dari migration project_member
    public function userMember()
    {
        return $this->hasMany(Project_member::class,'user_id');
    }

    //ini relasi dari migration task
    public function userTask(){
        return $this->hasMany(Task::class,'assigned_to');
    }
    public function createdTask(){
        return $this->hasMany(Task::class,'created_by');
    }
    public function updatedTask(){
        return $this->hasMany(Task::class,'updated_by');
    }

    //ini relasi dari migration task
    public function uploadTaskLampiran()
    {
        return $this->hasMany(TaskLampiran::class,'uploaded_by');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
