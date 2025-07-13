<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectType extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
