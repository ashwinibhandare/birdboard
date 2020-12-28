<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function a_user_has_project()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /**
     * @test
     */
    public function a_user_has_accessible_projects()
    {
        $john = $this->signIn();
        $project = ProjectFactory::ownedBy($john)->create();
        $this->assertCount(1, $john->accessibleProject());
        $sally = User::factory()->create();
        $rohn = User::factory()->create();
        ProjectFactory::ownedBy($rohn)->create()->invites($sally);
        $this->assertCount(1, $john->accessibleProject());
    }
}
