<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_a_path()
    {
        $project = Project::factory()->create();
        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /*
    * @test
    */
    public function a_project_belongs_to_owner()
    {
        $project = Project::factory()->create();
        $this->assertInstanceOf('App\Models\User',$project->owner);
    }

    /*
     * @test
     */
    public function it_can_add_a_task()
    {
        $project = Project::factory()->create();
        $task = $project->addTask('Test');
        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /**
     * @test
     */
    public function it_can_invite_a_user()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $project->invites($newUser = User::factory()->create());
        assertTrue($project->members->contains($newUser));
    }
}
