<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        // $this->signIn();
        // $this->actingAs(User::factory()->create());
        // $project= auth()->user()->projects()->create(Project::factory()->raw());  --or --
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->post($project->path() . '/tasks', ['body' => 'Loreum ipsum']);
        $this->get($project->path())->assertSee('Loreum ipsum');
    }

    /**
     * @test
     */
    public function a_tasks_requires_body()
    {
        // $this->signIn();
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attributes = Task::factory()->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function only_owner_can_add_task()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test test'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'Test test']);
    }

    /**
     * @test
     */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        ///$this->signIn();

        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
        // or
        // $project = app(ProjectFactory::class)->withTask(1)->create();
        // or
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);
        // $task = $project->addTask('Test test');

        $this->patch($project->tasks->first()->path(), [
            'body' => 'Change'
        ]);

        // or
        //$this->patch($project->path() . '/tasks/' . $project->tasks[0]->id, [
        //'body' => 'Change',
        //'completed' => true
        //]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Change'
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
        $this->patch($project->tasks->first()->path(), [
            'body' => 'Change',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Change',
            'completed' => true
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_incompleted()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
        $this->patch($project->tasks->first()->path(), [
            'body' => 'Change',
            'completed' => true
        ]);

        $this->patch($project->tasks->first()->path(), [
            'body' => 'Change',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'Change',
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function only_owner_of_project_may_update_task()
    {
        $this->signIn();

        // $project = Project::factory()->create();
        // $task = $project->addTask('Test test');

        $project = ProjectFactory::withTask(1)->create();
        $this->patch($project->tasks[0]->path(), [
            'body' => 'Change',
            'completed' => true
        ])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', [
            'body' => 'Change',
            'completed' => true
        ]);
    }
}
