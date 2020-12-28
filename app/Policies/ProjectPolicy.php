<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Project $project)
    {
        return $user->id == $project->owner_id || $project->members->contains($user);
    }

    public function manage(User $user, Project $project)
    {
        return $user->id == $project->owner_id;
    }
}
