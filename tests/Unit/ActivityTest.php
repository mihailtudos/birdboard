<?php

namespace Tests\Unit;

use App\Project;
use App\Activity;
use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/

    public function an_activity_has_a_user()
    {
        $user = $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => $user->id]);

        $this->assertEquals($user->id, $project->activity->first()->user->id);

    }
}
