<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectInvitationController extends Controller
{
    public function store(Project $project)
    {
        $this->authorize('manage', $project);
        Validator::make(\request()->all(), [
            'email' => ['required','exists:users,email']
        ],[
            'email.exists' => 'The user you are inviting must have birdboard acc'
        ])->validateWithBag('invitations');
//        \request()->validate([
//            'email' => ['required','exists:users,email']
//        ],[
//            'email.exists' => 'The user you are inviting must have birdboard acc'
//        ]);
        $user = User::whereEmail(\request('email'))->first();
        $project->invites($user);

        return redirect($project->path());
        //return redirect($project->path());
    }


}
