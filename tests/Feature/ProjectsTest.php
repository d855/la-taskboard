<?php

    namespace Tests\Feature;

    use App\Models\Project;
    use App\Models\User;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\WithFaker;
    use Tests\TestCase;

    class ProjectsTest extends TestCase
    {

        use WithFaker, RefreshDatabase;

        /**
         * A basic feature test example.
         *
         * @return void
         */
        public function test_a_user_can_create_a_project()
        {
            $this->withoutExceptionHandling();
            $this->signIn();

            $this->get('/projects/create')->assertStatus(200);

            $attributes = [
                'title' => $this->faker->sentence(4),
                'description' => $this->faker->sentences(1, true),
                'notes' => 'General notes here.'
            ];

            $response = $this->post('/projects', $attributes);

            $project = Project::where($attributes)->first();

            $response->assertRedirect($project->path());

            $this->assertDatabaseHas('projects', $attributes);

            $this->get($project->path())
                 ->assertSee($attributes['title'])
                 ->assertSee($attributes['description'])
                 ->assertSee($attributes['notes']);
        }

        public function test_a_user_can_update_a_project()
        {
            $this->signIn();
            $this->withoutExceptionHandling();
            $project = Project::factory()->create(['owner_id' => auth()->id()]);

            $this->patch($project->path(), [
                'title' => 'Changed',
                'description' => 'Changed',
                'notes' => 'Changed'
            ])->assertRedirect($project->path());

            $this->get($project->path() . '/edit')->assertOk();

            $this->assertDatabaseHas('projects', ['notes' => 'Changed']);

        }

        public function test_a_project_requires_a_title()
        {
            $this->signIn();

            $attributes = Project::factory()->raw(['title' => '']);
            $this->post('/projects', $attributes)->assertSessionHasErrors('title');
        }

        public function test_a_project_requires_a_description()
        {
            $this->signIn();

            $attributes = Project::factory()->raw(['description' => '']);
            $this->post('/projects', $attributes)->assertSessionHasErrors('description');
        }

        public function test_a_user_can_view_their_project()
        {
            $this->withoutExceptionHandling();

            $this->signIn();

            $project = Project::factory()->create(['owner_id' => auth()->id()]);

            $this->get($project->path())->assertSee($project->title);
        }

        public function test_an_authenticated_user_cannot_view_the_projects_of_others()
        {
            $this->signIn();

            $project = Project::factory()->create();

            $this->get($project->path())->assertStatus(403);
        }

        public function test_guests_cannot_manage_projects()
        {
            $project = Project::factory()->create();

            $this->post('/projects')->assertRedirect('login');
            $this->get('/projects/create')->assertRedirect('login');
            $this->get($project->path() . '/edit')->assertRedirect('login');
            $this->get('/projects', $project->toArray())->assertRedirect('login');
            $this->get($project->path())->assertRedirect('login');
        }

    }
