<?php

namespace Tests\Feature;

use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_project(): void
    {
        $this->signIn();

        $this->get('projects/create')->assertOk();

        $attributes= [
            'title' => $this->faker()->sentence(3),
            'description' => $this->faker()->sentence(10),
            'notes' => $this->faker()->sentence()
        ];


        $response = $this->post('projects', $attributes);;
        $project = Project::whereBelongsTo(auth()->user())->where($attributes)->first();

        $response->assertRedirect($project->path());
        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
                                ->assertSee($attributes['title'])
                                ->assertSee($attributes['description']);
    }

    /** @test */
    public function authenticated_can_view_their_project(): void
    {
        $project = ProjectFactory::create();

        $response = $this->actingAs($project->user)->get($project->path());

        $response->assertOk()
                        ->assertSee($project->title)
                        ->assertSee($project->description);
    }

    /** @test */
    public function authenticated_user_can_update_their_project(): void
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $this->get($project->path() . '/edit')->assertOk();

        $response = $this->patch($project->path(), $attributes = ['title' => 'Updated Title', 'description' => 'updated desc', 'notes' => 'updated notes']);

        $this->assertDatabaseHas('projects', $attributes);

        $response->assertRedirect($project->path());
    }

    /** @test */
    public function authenticated_can_update_general_notes(): void
    {
        $user = $this->signIn();

        $project = ProjectFactory::ownedBy($user)->create();

        $response = $this->patch($project->path(), $attributes = ['notes' => 'updated notes']);

        $this->assertDatabaseHas('projects', $attributes);

        $response->assertRedirect($project->path());
    }

    /** @test */
    public function authenticated_cannot_update_others_project(): void
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $response = $this->patch($project->path());

        $response->assertStatus(403);
    }

    /** @test */
    public function authenticated_user_can_delete_their_project(): void
    {

        $project = ProjectFactory::create();

        $response = $this->actingAs($project->user)->delete($project->path());

        $this->assertDatabaseMissing('projects', $project->toArray());

        $response->assertRedirect('projects');
    }

    /** @test */
    public function unauthorized_user_cannot_delete_projects(): void
    {

        $project = ProjectFactory::create();

        $response = $this->delete($project->path());

        $response->assertRedirect('login');

        $user = $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }


    /** @test */
    public function authenticated_cannot_view_others_project(): void
    {
        $this->signIn();

        $project = ProjectFactory::create();

        $response = $this->get($project->path());

        $response->assertStatus(403);
    }

    /** @test */
    public function autenticated_user_can_view_projects_they_have_been_invited()
    {
        $user = $this->signIn();

        $project = tap(ProjectFactory::create())->invite($user);

        $this->get('projects')->assertSeeText($project->title);
    }

    /** @test */
    public function a_project_title_is_valid(): void
    {
        $this->signIn();

        $this->post('projects', Project::factory()->raw(['title' => 'Valid title']))->assertValid('title');

    }

    /** @test */
    public function a_project_description_is_valid(): void
    {
        $this->signIn();

        $this->post('projects', Project::factory()->raw(['description' => 'Valid description']))->assertValid('description');

    }

    /** @test */
    public function a_project_require_title_and_description(): void
    {
        $this->signIn();

        $this->post('projects', Project::factory()->raw(['title' => '', 'description' => '']))->assertSessionHasErrors(['title', 'description']);

    }

    /** @test */
    public function guests_cannnot_manage_projects(): void
    {


        $project = ProjectFactory::create();

        $this->get('projects/create')->assertRedirect('login');

        $this->post('projects', $project->toArray())->assertRedirect('login');

        $this->get('projects')->assertRedirect('login');

        $this->get($project->path() . "/edit")->assertRedirect('login');

        $this->get($project->path())->assertRedirect('login');

    }
}
