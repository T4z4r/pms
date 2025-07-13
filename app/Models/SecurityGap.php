<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityGap extends Model
{
    protected $fillable = [
        'security_gap_template_id', 'title', 'description', 'project_id',
        'status', 'start_date', 'end_date', 'color', 'created_by', 'assigned_to'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function template()
    {
        return $this->belongsTo(SecurityGapTemplate::class, 'security_gap_template_id');
    }

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
}
