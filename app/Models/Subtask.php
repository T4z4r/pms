<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtask extends Model
{
    protected $fillable = ['task_id', 'title', 'description', 'status', 'due_date'];

    public function task()
    {
        return $this->belongsTo(Task::class);
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


    public function updates()
    {
        return $this->morphMany(TaskUpdate::class, 'updatable');
    }
}
