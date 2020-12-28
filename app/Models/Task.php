<?php

namespace App\Models;

use App\RecordActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, RecordActivity;


    protected $guarded = [];

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];
    protected static $recordableEvent = ['created', 'deleted'];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function path()
    {
        return "/projects/{$this->project->id}/tasks/{$this->id}";
    }

    public function complete()
    {
        $this->update(['completed' => true]);
        $this->recordActivity('updated_task');
    }

    public function incompleted()
    {
        $this->update(['completed' => false]);
        $this->recordActivity('incomplete_task');
    }

}
