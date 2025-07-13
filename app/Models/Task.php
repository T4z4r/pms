<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'project_id', 'creator_id', 'status', 'due_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function subtasks()
    {
        return $this->hasMany(Subtask::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function remarks()
    {
        return $this->morphMany(Remark::class, 'remarkable');
    }

    public function review()
    {
        return $this->hasOne(TaskReview::class);
    }


    public function updates()
    {
        return $this->morphMany(TaskUpdate::class, 'updatable');
    }
}
