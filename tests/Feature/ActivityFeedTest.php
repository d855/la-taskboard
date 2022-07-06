<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase;


    public function test_creating_a_project_generates_activity()
    {
        $this->withoutExceptionHandling();

        $project = Project::factory()->create();

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_a_project_generates_activity()
    {
        $project = Project::factory()->create();
        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_a_new_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $project->addTask('Some task');

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    public function test_completing_a_new_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $project->addTask('Some task');

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true
        ]);

        $this->assertCount(3, $project->activity);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    public function test_incompleting_a_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $project->addTask('Some task');

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $this->assertCount(4,  $project->fresh()->activity);

        $this->assertEquals('incomplete_task', $project->fresh()->activity->last()->description);
    }

    public function test_deleting_a_task_records_project_activity()
    {
        $project = Project::factory()->create();
        $project->addTask('Some task');

        $project->tasks[0]->delete();
        $this->assertCount(3, $project->activity);
    }



}
