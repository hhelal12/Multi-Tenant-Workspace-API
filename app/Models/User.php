<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }



    // user be in many workspace
    public function workspaces()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_user');
    }

    // user leads many Workspaces
    public function leadingWorkspaces()
    {
        return $this->hasMany(Workspace::class, 'leader_id');
    }

    // user created many Tasks
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    // user is assigned many Tasks
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_id');
    }
}
