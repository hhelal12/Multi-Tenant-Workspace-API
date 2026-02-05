<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'leader_id',
    ];

    // leader of the workspace
    public function leader()
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    // members of the workspace 
    public function users()
    {
        return $this->belongsToMany(User::class, 'workspace_user');
    }

    // tasks inside the workspace
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
