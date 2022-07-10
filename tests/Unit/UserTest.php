<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_a_user_has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    function a_user_has_accessible_projects()
    {
        $john = User::factory()->create();
        $this->signIn($john);

        $project = Project::factory()->create(['owner_id' => $john->id ]);

        $this->assertCount(1, $john->accessibleProjects());

        $sally = User::factory()->create();
        $nick = User::factory()->create();

        $sallyProject = Project::factory()->create(['owner_id' => $sally->id]);
        $sallyProject->invite($nick);

        $this->assertCount(1, $john->accessibleProjects());

        $sallyProject->invite($john);
        $this->assertCount(2, $john->accessibleProjects());
    }
}
