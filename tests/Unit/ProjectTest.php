<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use \App\Project;

class ProjectTest extends TestCase
{

    use RefreshDatabase;
   //test for a model
    //checking if the model works accordingly
    /** @test */

    public function it_has_a_path()
    {

        //let's assume we have a project
        $project = factory(Project::class)->create();;

        //when calling path it should show the same as we would concatenate it
        $this->assertEquals('/projects/' .$project->id, $project->path());
    }
    /** @test */
    public function a_project_belongs_to_an_owner()
    {
        //grab any project for testing purpose
        $project = factory(Project::class)->create();

        //project owner must be an instanceOf User class in order to pass the test
        $this->assertInstanceOf(User::class, $project->owner);
    }
    /** @test */
    public function project_can_add_task()
    {
        $project = factory('App\Project')->create();

        $task = $project->addTask('Task added');

        $this->assertCount(1, $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
    }

    /** @test */
    public function owner_can_invite_a_new_user()
    {
        $project = factory('App\Project')->create();

        $user = factory(User::class)->create();

        $project->invite($user);

        $this->assertTrue($project->members->contains($user));
    }
}
