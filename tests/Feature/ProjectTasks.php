<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasks extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_project_can_have_tasks()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $this->post($project->path() . '/tasks', ['body' => 'Test task']);
        $this->get($project->path())->assertSee('Test task');
    }

    public function test_a_task_requires_a_body()
    {
        $this->signIn();
        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $attributes = Task::factory()->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
    }

    public function test_only_the_owner_of_project_may_add_tasks()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $this->post($project->path() . '/tasks', ['body' => 'Test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }

    public function test_only_the_owner_of_project_may_update_task()
    {
        $this->signIn();
        $project = Project::factory()->create();

        $task = $project->addTask('test task');

        $this->patch($project->path() . '/tasks/' . $task->id, ['body' => 'changed'])->assertStatus(403);
        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    public function test_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask('test Task');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
        ]);
    }

    public function test_task_can_be_completed()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );

        $task = $project->addTask('test Task');
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    public function test_task_can_be_marked_as_incomplete()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            Project::factory()->raw()
        );
        $task = $project->addTask('test Task');

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'changed',
            'completed' => false,
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false,
        ]);
    }
}
