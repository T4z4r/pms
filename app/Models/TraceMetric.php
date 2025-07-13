<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TraceMetric extends Model
{
    protected $fillable = ['project_id', 'metric_name', 'value', 'recorded_at'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
