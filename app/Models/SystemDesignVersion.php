<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemDesignVersion extends Model
{
    protected $fillable = ['system_design_id', 'version', 'data', 'thumbnail', 'created_by'];

    public function design()
    {
        return $this->belongsTo(SystemDesign::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}