<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPlan extends Model
{
    protected $fillable = ['title', 'description', 'project_id', 'start_date', 'end_date', 'color', 'created_by', 'assigned_to'];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function testCases()
    {
        return $this->hasMany(TestCase::class);
    }
}
