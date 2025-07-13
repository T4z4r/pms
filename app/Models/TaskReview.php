<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskReview extends Model
{
    protected $fillable = ['task_id', 'reviewer_id', 'rating', 'review_comments', 'approved_at'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}
