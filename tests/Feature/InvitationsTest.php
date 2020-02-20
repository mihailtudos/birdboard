<?php

namespace Tests\Feature;

use App\Http\Controllers\ProjectsController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/

    public function project_owner_can_invite_users()
    {
        //given we have a project
        //the owner of the project invites another user
        //then the newly added user gets permissions to add tasks

        //factoring a project
        $project = ProjectFactory::create();
        dd($project -> owner);
        //project(owner) invites new user
        $project->invite($newUser = factory(User::class)->create());

        //signing in the new user
        $this->signIn($newUser);

        //the new user will hit the endpoint and submit the following attributes
        $this->post(action('ProjectTasksController@store', $project), $tasks = ['body' => 'Changed task']);

        //asserting if the task attributes are present in database table tasks
        $this->assertDatabaseHas('tasks', $tasks);
    }
}
