<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    public function a_project_can_have_tasks()
    {
        //sign in a user
        //$this->signeIn();

        //given we have a project created by the signed in user
        //when end point (link) is hit it shoudl successfully add a task to the project
        //$project = auth()->user()->projects()->create(factory('App\Project')->raw());

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() .'/tasks', ['body' => 'Test']);

        //accessing project's page we should see the 'Test task' task
        $this->get($project->path())->assertSee('Test');

    }

    /** @test */
    public function only_the_owner_of_the_project_can_update_the_tasks()
    {

        $this->signeIn();
        $project = ProjectFactory::withTask(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'updated'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);

    }


    /** @test */
    public function a_task_can_be_updated()
    {
        //create a project object
        $project =ProjectFactory::withtask(1)->create();


        //assign the auth user to the project
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),
            [
                'body' => 'changed updated',
            ]);


        $this->assertDatabaseHas('tasks', [
            'body' => 'changed updated',
            ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        //create a project object
        $project =ProjectFactory::withtask(1)->create();


        //assign the auth user to the project
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),
            [
                'body' => 'changed updated',
                'completed' => true,
            ]);


        $this->assertDatabaseHas('tasks', [
            'body' => 'changed updated',
            'completed' => true
            ]);
    }
    /** @test */
    public function a_task_can_be_incompleted()
    {
        $this->withoutExceptionHandling();

        //create a project object
        $project =ProjectFactory::withtask(1)->create();

        //assign the auth user to the project
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),
            [
                'body' => 'changed updated',
                'completed' => true,
            ]);

        //assign the auth user to the project
        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(),
            [
                'body' => 'changed updated',
                'completed' => false,
            ]);


        $this->assertDatabaseHas('tasks', [
            'body' => 'changed updated',
            'completed' => false
            ]);
    }



    /** @test */
    public function a_task_require_a_body()
    {
//        $this->signeIn();
//
//        $project = auth()->user()->projects()->create(factory(Project::class)->raw());
        $project=ProjectFactory::create();

        $attributes = factory(Task::class)->raw(['body'=>'']);

        $this->actingAs($project->owner)
            ->post($project->path() .'/tasks', $attributes)
            ->assertSessionHasErrors('body');

    }

    /** @test */
    public function only_the_owner_of_the_project_can_add_tasks()
    {
        $this->signeIn();

        //somebody's project
        $project = factory(Project::class)->create();

        //post a task to somebody's project
        //to prohibit that action an if or policy was included in the controller
        $this->post($project->path() .'/tasks', ['body' => 'only_the_owner_of_the_project_can_add_tasks'])->assertStatus(403);

        //Checking if the record is missing from db
        $this->assertDatabaseMissing('tasks', ['body' => 'only_the_owner_of_the_project_can_add_tasks']);

    }

}
