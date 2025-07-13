<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SystemManual extends Model
{
    protected $fillable = ['system_id', 'title', 'description', 'content', 'created_by', 'updated_by'];

    public function system()
    {
        return $this->belongsTo(System::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
