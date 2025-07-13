<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $fillable = ['system_id', 'title', 'description', 'priority', 'status', 'created_by'];

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}