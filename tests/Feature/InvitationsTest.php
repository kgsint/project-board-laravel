<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * @test
     */
    public function owner_of_the_project_can_invite_members()
    {
        $project = Project::factory()->create();

        $userToInvite = User::factory()->create();

        $this->actingAs($project->user)
                        ->post("projects/{$project->id}/invite", ['email' => $userToInvite->email])
                        ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /**
     * @test
     */
    public function invited_users_can_update_project()
    {
        $project = Project::factory()->create();

        $project->invite($user = User::factory()->create());

        $this->signIn($user);

        $this->post("projects/{$project->id}/tasks", $task = ['body' => 'test task']);

        $this->assertDatabaseHas('tasks', $task);
    }

    /**
     * @test
     */
    public function invited_email_address_must_be_a_valid()
    {
        $project = Project::factory()->create();

        $this
            ->actingAs($project->user)->post(
                        "projects/{$project->id}/invite",
                        ['email' => 'notvalidaddress@gmail.com']
                    )
                    ->assertSessionHasErrors('email');
    }

    /**
     * @test
     */
    public function none_owner_of_the_project_cannot_invite_users()
    {
        $project = Project::factory()->create();

        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $this->actingAs($user)->post("projects/{$project->id}/invite", ['email' => $anotherUser->email])->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
                        ->post("projects/{$project->id}/invite", ['email' => $anotherUser->email])
                        ->assertStatus(403);
    }
}
