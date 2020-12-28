<?php

namespace App\Models;

use App\RecordActivity;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory, RecordActivity;


    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function addTask(array $body)
    {
        return $this->tasks()->createMany($body);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function invites(User $user)
    {
        $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}

