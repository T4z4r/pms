<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTag extends Model
{
    protected $fillable = ['name', 'status'];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_project_tag');
    }
}
