<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    // public function guests_cannot_add_task_to_project(): void
    // {
    //     $this->withoutExceptionHandling();


    //     $project = Project::factory()->create(['user_id' => null]);

    //     $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertRedirect('login');
    // }

    /**
     * @test
     */
    public function a_task_can_be_updated(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        // ProjectFactory from Tests/Setup
        $project = ProjectFactory::withTask(1)->create();


        $this->actingAs($project->user)
                    ->patch($project->tasks->first()->path(), $attributes = ['body' => 'Updated'])
                    ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        // ProjectFactory from Tests/Setup
        $project = ProjectFactory::withTask(1)->create();


        $this->actingAs($project->user)
                    ->patch($project->tasks->first()->path(), $attributes = ['body' => 'body', 'completed' => true])
                    ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    public function a_task_can_be_incompleted(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        // ProjectFactory from Tests/Setup
        $project = ProjectFactory::withTask(1)->create();


        $this->actingAs($project->user)
                    ->patch($project->tasks->first()->path(), $attributes = ['body' => 'body', 'completed' => false])
                    ->assertRedirect($project->path());

        $this->assertDatabaseHas('tasks', $attributes);
    }

    /**
     * @test
     */
    public function only_owner_of_the_project_can_update_the_task(): void
    {
        $this->signIn();

        // ProjectFactory from Tests/Setup
        $project = ProjectFactory::withTask(1)->create();

        $this->patch($project->tasks->first()->path(), ['body' => 'Updated', 'completed' => true])
                    ->assertStatus(403);

    }

    /**
     * @test
     */
    public function only_owner_of_the_project_can_add_task(): void
    {

        $this->signIn();

        $project = ProjectFactory::create();

        $this->post($project->path() . '/tasks', ['body' => 'Some task to complete'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Some task to complete']);

    }

    /**
     * @test
     */
    public function project_can_have_tasks(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();


        $project = ProjectFactory::create();

        $this->actingAs($project->user)
                        ->post($project->path() . '/tasks', ['body' => 'Test task']);

        $this->get($project->path())
                                    ->assertSee('Test task');
    }

    /**
     * @test
     */
    public function body_of_a_task_is_valid(): void
    {
        $this->withoutExceptionHandling();
        $this->signIn();


        $project  = ProjectFactory::create();

        // dd(Task::factory()->raw(['body' => ""]));

        $this->actingAs($project->user)
                                ->post($project->path() . '/tasks', Task::factory()->raw(['project_id' => $project->id]))
                                ->assertValid('body');
    }
}
