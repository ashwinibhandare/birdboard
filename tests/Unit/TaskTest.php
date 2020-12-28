<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    function it_has_a_path()
    {
        $this->withoutExceptionHandling();
        $task = Task::factory()->create();
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /**
     * @test
     */
    function it_belongs_to_a_project()
    {
        $task = Task::factory()->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /**
     * @test
     */
    function it_can_be_complete()
    {
        $task = Task::factory()->create();
        $this->assertFalse($task->fresh()->completed);
        $task->complete();
        $this->assertTrue($task->fresh()->completed);
    }
    /**
     * @test
     */
    function it_can_be_incompleted()
    {
        $task = Task::factory()->create(['completed' => true]);
        $this->assertTrue($task->fresh()->completed);
        $task->incompleted();
        $this->assertFalse($task->fresh()->completed);
    }
}
