<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'system_id', 'module_id', 'submodule_id', 'creator_id', 'created_by'];

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function submodule()
    {
        return $this->belongsTo(Submodule::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    // public function tasks()
    // {
    //     return $this->belongsToMany(Task::class, 'feature_task');
    // }
}