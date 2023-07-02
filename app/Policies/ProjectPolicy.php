<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;


class ProjectPolicy
{
    // only the owner of the project can manage the project
    public function manage(User $user, Project $project): bool
    {
        return $user->is($project->user);
    }

    // owner of the project and associated memebers can update the project
    public function update(User $user, Project $project): bool
    {
        return $user->is($project->user) || $project->members->contains($user);
    }

}
