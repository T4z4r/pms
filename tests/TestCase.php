<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = [
        'test_plan_id',
        'title',
        'description',
        'expected_outcome',
        'status',
        'created_by',
        'feature_id',
        
    ];

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

    // Existing relationships (e.g., testPlan, creator)
    public function testPlan()
    {
        return $this->belongsTo(TestPlan::class);
    }
}
