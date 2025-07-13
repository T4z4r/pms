<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    protected $fillable = ['name', 'description', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_role_user')->withPivot('project_id');
    }
}
