<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    /*a test to start with
    from the outside to inside */
    use WithFaker, RefreshDatabase;

    /** @test */
    public function guests_cannot_view_projects()
    {
        $attributes = factory('App\Project')->raw();
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_cannot_create_projects()
    {
        $attributes = factory('App\Project')->raw();
        //if I submit a post request with to the specified address and send the attributes
        $this->get('/projects/create', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function guests_may_not_view_projects()
    {
        $this->post('/projects')->assertRedirect('login');

    }

    /** @test */
    public function guests_may_not_view_a_single_projects()
    {
        //grab a project
        $project = factory('App\Project')->create();
        //if a guest tries to view the project it will be redirected to login page
        //due to the middleware added on to the route
        $this->get($project->path())->assertRedirect('login');
    }

     /** @test */
    public function a_user_can_create_a_project()
    {   //disable error handling
        $this->withoutExceptionHandling();

        //get a signed in user
        $this->signeIn();

        //assert if the user can access the project create page and that the page actually exist
        $this->get('/projects/create')->assertStatus(200);

        //further the test is for preparing the arguments and testing the through pass to the endpoint

        //the attributes we are working with are going to be saved in an array
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence,
            'notes' => 'General notes',
        ];


        //if I submit a post request with to the specified address and send the attributes
        $response = $this->post('/projects', $attributes);

        $project = Project::where($attributes)->first();

         $response->assertRedirect($project->path());

        //I should have a database record containing the attributes send at previous step
        $this->assertDatabaseHas('projects', $attributes);

        //Would I see a the title of a project if I would access /projects
        //$this->get('/projects')->assertSee($attributes['title']);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }
    /** @test */
    public function a_user_can_update_a_project()
    {
        //get an authenticated user
        $this->signeIn();

        $this->withoutExceptionHandling();

        //given we have a project
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->patch($project->path(),[
            'notes' => 'general notes'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'general notes']);
    }

    /** @test */
    public function a_user_can_view_their_projects()
    {
        //get an authenticated user
        $this->signeIn();

        $this->withoutExceptionHandling();

        //given we have a project
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        //would we be able to access it
        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        //$this->withoutExceptionHandling();
        //grab an authenticated user
        $this->signeIn();

        //grab a random project not created by the signed in user to make sure he cannot view it

        $project = factory('App\Project')->create();

        //and then we try to visit that project
        //check or assert if the status of the request would be 403
        $this->get($project->path())->assertStatus(403);
    }
    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        //$this->withoutExceptionHandling();
        //grab an authenticated user
        $this->signeIn();

        //grab a random project not created by the signed in user to make sure he cannot view it

        $project = factory('App\Project')->create();

        //and then we try to visit that project
        //check or assert if the status of the request would be 403
        $this->patch($project->path(), [])->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signeIn();
        $attributes = factory('App\Project')->raw(['title'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signeIn();
        $attributes = factory('App\Project')->raw(['description'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}