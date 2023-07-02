<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrackActivityTest extends TestCase
{
    use RefreshDatabase, WithFaker;


    /**
     * @test
     */
    public function creating_a_project_track_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activity);

        tap($project->activity->first(), function($activity) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    /**
     * @test
     */
    public function updating_a_project_track_activity()
    {
        $project = ProjectFactory::create();

        $originalTitle = $project->title;

        $project->update(['title' => 'Updated']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) use($originalTitle) {
            $this->assertEquals('updated', $activity->description);

            $expectedChanges = [
                'before' => [
                    'title' => $originalTitle
                ],
                'after' => [
                    'title' => 'Updated',
                ]
            ];

            $this->assertEquals($expectedChanges, $activity->changes);
        });
    }

     /**
     * @test
     */
    public function creating_a_task_track_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });

    }

    /**
     * @test
     */
    public function completing_a_task_track_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('some title');

        $this->actingAs($project->user)->patch($project->tasks->first()->path(), ['body' => 'update', 'completed' => true]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /**
     * @test
     */
    public function incompleting_a_task_track_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('some title');

        $this->actingAs($project->user)->patch($project->tasks->first()->path(), ['body' => 'update', 'completed' => true]);

        $this->assertCount(3, $project->activity);

        $project->refresh();

        $this->actingAs($project->user)->patch($project->tasks->first()->path(), ['body' => 'update', 'completed' => false]);

        $this->assertCount(4, $project->fresh()->activity);

        tap($project->fresh()->activity->last(), function($activity) {
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    /**
     * @test
     */
    public function deleting_a_task_track_activity()
    {
        $project = ProjectFactory::withTask(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activity);

        $this->assertEquals('deleted_task', $project->activity->last()->description);
    }
}
