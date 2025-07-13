<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecurityGapTemplate extends Model
{
    protected $fillable = ['title', 'description', 'version_number', 'created_by'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function securityGaps()
    {
        return $this->hasMany(SecurityGap::class);
    }
}
