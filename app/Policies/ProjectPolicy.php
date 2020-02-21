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
        //a project can be updated if is the owner of the project or a project team member
        return $user->is($project->owner) || $project->members->contains($user);
    }
}
