<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }


    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_role_user')->withPivot('project_role_id');
    }

    // public function roles()
    // {
    //     return $this->belongsToMany(ProjectRole::class, 'project_role_user')->withPivot('project_id');
    // }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_user');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'creator_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }

    public function remarks()
    {
        return $this->hasMany(Remark::class);
    }

    public function taskReviews()
    {
        return $this->hasMany(TaskReview::class, 'reviewer_id');
    }
}
