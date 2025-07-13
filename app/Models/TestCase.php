<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = ['test_plan_id', 'title', 'description', 'expected_outcome', 'status', 'created_by'];

    protected $casts = [
        'status' => 'string',
    ];

    public function testPlan()
    {
        return $this->belongsTo(TestPlan::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
