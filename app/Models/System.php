<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    protected $fillable = ['name', 'description', 'status', 'created_by', 'assigned_to', 'is_all_users'];

    protected $casts = [
        'is_all_users' => 'boolean',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_system')->withTimestamps();
    }

    public function projectSystems()
    {
        return $this->hasMany(ProjectSystem::class, 'system_id')->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order', 'asc');
    }
    public function submodules()
    {
        return $this->hasMany(SubModule::class);
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}