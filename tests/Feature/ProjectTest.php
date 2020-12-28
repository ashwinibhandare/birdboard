<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /**
     * @test
     * A basic feature test example.
     *
     * @return void
     */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        // $this->actingAs(User::factory()->create());
        $this->signIn();
        $this->get('projects/create')->assertStatus(200);
//        $attribute = [
//            'title' => $this->faker->sentence,
//            'body' => $this->faker->sentence,
//            'notes' => 'test'
//        ];

        $attribute = Project::factory()->raw(['owner_id' => auth()->id()]);
        $responce = $this->followingRedirects()->post('/projects', $attribute);
        //$project = Project::where($attribute)->first();
        //$responce->assertRedirect($project->path());
        //$this->assertDatabaseHas('projects', $attribute);
        $responce->assertSee($attribute['title'])->assertSee($attribute['body']);
    }

    /**
     * @test
     */
    function tasks_can_be_included_as_part_of_a_new_project_creation()
    {
        $this->signIn();
        $attributes = Project::factory()->raw();
        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 1']
        ];
        $this->post('/projects', $attributes);
        $this->assertCount(2, Project::first()->tasks);
    }

    /**
     * @test
     */
    public function user_can_delete_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attribute = [
            'title' => 'Changed',
            'notes' => 'test',
            'body' => 'test test'
        ];
        $this->delete($project->path(), $attribute)->assertRedirect('/projects');
        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /**
     * @test
     */
    public function unautherized_user_cannot_delete_project()
    {
       // $this->withoutExceptionHandling();
        $project = Project::factory()->create();

        $this->delete($project->path())->assertRedirect('/login');
        $user = $this->signIn();
        $this->delete($project->path())->assertStatus(403);
        $project->invites($user);
        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function a_project_require_title()
    {
        $this->signIn();
        $attributes = Project::factory()->raw(['title' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /**
     * @test
     */
    public function a_project_require_body()
    {
        $this->signIn(); // Act auth user is login
        $attributes = Project::factory()->raw(['body' => '']);
        $this->post('/projects', $attributes)->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function a_user_can_view_their_project()
    {
        // $this->signIn();
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::ownedBy($this->signIn())->create();
        //$this->withoutExceptionHandling();
        // $project = Project::factory()->create();
        $this->get($project->path())->assertSee($project->title)->assertSee($project->body);
    }

    /**
     * @test
     */
    public function an_authenticated_user_cannot_view_project_of_others()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $this->get($project->path())->assertStatus(403);
    }

    /**
     * @test
     */
    public function guest_cannot_manage_projects()
    {
        $project = Project::factory()->create();
        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/edit')->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
    }

    /**
     * @test
     */
    public function a_user_can_update_project()
    {
        $this->withoutExceptionHandling();

        // $this->signIn();
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attribute = [
            'title' => 'Changed',
            'notes' => 'test',
            'body' => 'test test'
        ];
        $this->patch($project->path(), $attribute);
        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attribute);
    }

    /**
     * @test
     */
    public function a_user_can_update_project_general_notes()
    {
        $this->withoutExceptionHandling();

        // $this->signIn();
        // $project = Project::factory()->create(['owner_id' => auth()->id()]);
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $attribute = ['notes' => 'test'];
        $this->patch($project->path(), $attribute);
        $this->get($project->path() . '/edit')->assertOk();
        $this->assertDatabaseHas('projects', $attribute);
    }

    /**
     * @test
     */
    public function authenticated_user_cannot_update_others_project()
    {
        $this->signIn();
        $project = Project::factory()->create();
        $attribute = ['notes' => 'test'];
        $this->patch($project->path(), $attribute)->assertStatus(403);
        $this->assertDatabaseMissing('projects', $attribute);
    }

    /**
     * @test
     */
    public function user_can_see_all_projects_have_been_invited_to_their_dashboard()
    {
        $sallyProject = tap(Project::factory()->create())->invites($this->signIn());

        $this->get('/projects')
            ->assertSee($sallyProject->title);

    }
}
