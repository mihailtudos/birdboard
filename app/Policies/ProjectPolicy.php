<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;


    public function update(User $user, Project $project)
    {
        //if the auth user is not the owner of the project aboard
        return $user->is($project->owner);
    }
}
