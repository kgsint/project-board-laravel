<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $project = Project::factory()->create();

        $this->assertEquals("/projects/{$project->id}", $project->path());
    }


    public function test_it_has_user()
    {
        $project = Project::factory()->create();

        $this->assertInstanceOf(User::class, $project->user);
    }

    public function test_it_can_add_a_task()
    {
        $project = Project::factory()->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_it_can_invite_member()
    {
        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->assertTrue($project->members->contains($user));
    }
}
