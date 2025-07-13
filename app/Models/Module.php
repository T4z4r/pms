<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'system_id', 'order'];

    public function system()
    {
        return $this->belongsTo(System::class);
    }


    public function submodules()
    {
        return $this->hasMany(Submodule::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class);
    }
}