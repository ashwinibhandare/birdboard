<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    protected $taskCount = 0;
    public function withTask($count)
    {
        $this->taskCount = $count;

        return $this;
    }
    public function create()
    {
        dd("Asdasd");
        $project = Project::factory()->create([
            'owner_id' => User::factory()
        ]);
        Task::factory()->count($this->taskCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
