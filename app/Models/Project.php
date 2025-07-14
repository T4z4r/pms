<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'project_type_id', 'project_priority_id', 'status', 'created_by', 'client_id', 'updated_by'];

    public function projectType()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function projectPriority()
    {
        return $this->belongsTo(ProjectPriority::class);
    }

    public function roles()
    {
        return $this->belongsToMany(ProjectRole::class, 'project_role_user')->withPivot('user_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_role_user')->withPivot('project_role_id');
    }

    public function tags()
    {
        return $this->belongsToMany(ProjectTag::class, 'project_project_tag');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function traceMetrics()
    {
        return $this->hasMany(TraceMetric::class);
    }


    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // public function systems()
    // {
    //     return $this->hasMany(System::class, 'project_system');
    // }

    // public function systems()
    // {
    //     return $this->hasMany(ProjectSystem::class, 'project_id');
    // }

    public function systems()
    {
        return $this->belongsToMany(System::class, 'project_system')->withTimestamps();
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
