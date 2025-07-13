<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
    protected $fillable = ['updatable_id', 'updatable_type', 'user_id', 'content'];

    public function updatable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
