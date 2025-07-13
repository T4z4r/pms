<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodule extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
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
