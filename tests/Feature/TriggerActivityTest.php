<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    /**
     * @test
     */
    public function updating_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();
        $originalTitle = $project->title;
        $project->update(['title' => 'change']);
        //dd($this->count($project->activity()));
        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function($activity) use ($originalTitle){
            $this->assertEquals('updated', $activity->description);
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'change'],
            ];

            $this->assertEquals($expected, $activity->activityChanges);
        });
    }

    /**
     * @test
     */
    public function create_a_new_task()
    {
        $project = ProjectFactory::create();
        $project->addTask('Some Task');
        $this->assertCount(2, $project->activity);
        tap($project->activity->last(), function($activity){
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some Task', $activity->subject->body);
        });

        //$this->assertEquals('created_task', $project->activity->last()->description);
    }

    /**
     * @test
     */
    public function incompleting_a_task()
    {
        $this->signIn();
        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);
        $this->assertCount(3, $project->activity);
        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);
        $this->assertCount(4, $project->fresh()->activity);
        $this->assertEquals('incomplete_task', $project->fresh()->activity->last()->description);
    }

    /**
     * @test
     */
    public function deleting_a_task()
    {
        $this->signIn();
        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
        $project->tasks[0]->delete();
        $this->assertCount(3, $project->fresh()->activity);
    }

//    /**
//     * @test
//     */
//    public function completing_a_new_task_record_project_activity()
//    {
//        $this->signIn();
//        $project = ProjectFactory::ownedBy($this->signIn())->withTask(1)->create();
//        $this->patch($project->tasks[0]->path(), [
//            'body' => 'foobar',
//            'completed' => true
//        ]);
//        $this->assertCount(4, $project->fresh()->activity);
//        $this->assertEquals('completed_task', $project->fresh()->activity->last()->description);
//
//    }
}
