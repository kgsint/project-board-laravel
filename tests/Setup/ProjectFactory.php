<?php

namespace Tests\Setup;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProjectFactory
{
    private $user;
    private int $taskCount = 0;

    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    public function withTask($taskCount)
    {
        $this->taskCount = $taskCount;

        return $this;
    }

    public function create()
    {
        $project = Project::factory()->create(['user_id' => $this->user ?? User::factory()]);

        Task::factory($this->taskCount)->create(['project_id' => $project->id]);

        return $project;
    }
}
