<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;

use Facades\Tests\Setup\ProjectFactory;
use Facades\Tests\Setup\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function invited_users_may_update_project_details()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $project->invites($newUser = User::factory()->create());
        $this->signIn($newUser);
        $this->post($project->path() . '/tasks', $task = ['body' => 'Foo Task']);
        $this->assertDatabaseHas('tasks', $task);
    }
    /**
     * @test
     */
    public function non_owner_may_not_invite_user()
    {
        $project = Project::factory()->create();
        $user = User::factory()->create();
        $assertInvitationForbidden = function() use ($user, $project){
            $this->actingAs($user)
                 ->post($project->path().'/invitations')
                 ->assertStatus(403);
        };
        $assertInvitationForbidden();
        $project->invites($user);
        $assertInvitationForbidden();

    }

    /**
     * @test
     */
    function a_project_can_invite_user()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $userInvite = User::factory()->create();
        $this->post($project->path().'/invitations', [
            'email' => $userInvite->email
        ])
        ->assertRedirect($project->path());
        $this->assertTrue(
            $project->members->contains($userInvite)
        );
    }

    /**
     * @test
     */
    function invite_email_address_must_be_associated_with_valid_birdboard_account()
    {
       // $this->withoutExceptionHandling();
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->post($project->path().'/invitations', [
            'email' => 'notvalidauser@gmail.com'
        ])
        ->assertSessionHasErrors([
            'email' => 'The user you are inviting must have birdboard acc'
        ], null, 'invitations');
    }
}
