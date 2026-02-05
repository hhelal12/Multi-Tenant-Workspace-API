<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'workspace_id',
        'creator_id',
        'assigned_to_id',
        'status',
        'deadline',
    ];

    // task belongs to a workspace
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }

    // user who created the task
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // user assigned to the task 
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
