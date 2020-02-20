<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
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
        $this->post('/projects')->assertRedirect('/login');
    }

    /** @test */
    public function guests_cannot_create_projects()
    {
        $attributes = factory('App\Project')->raw();
        //if I submit a post request with to the specified address and send the attributes
        $this->get('/projects/create', $attributes)->assertRedirect('login');
    }

    /** @test */
    public function unauthorised_users_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);


    }

    /** @test */
    public function guests_cannot_edit_projects()
    {
        $attributes = factory('App\Project')->raw();
        //if I submit a post request with to the specified address and send the attributes
        $this->get('/projects/edit', $attributes)->assertRedirect('login');
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

        //get a signed in user
        $this->signIn();

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
    public function a_user_can_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function a_user_can_update_a_project()
    {
        //get an authenticated user
        //$this->signeIn();

        //given we have a project
        //$project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'general notes'])
            ->assertRedirect($project->path());

        $this->get($project->path() .'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'general notes'])
            ->assertRedirect($project->path());

        $this->get($project->path() .'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes);
    }
    /** @test */
    public function a_user_can_view_their_projects()
    {
        //get an authenticated user
        //$this->signeIn();

        //given we have a project
        //$project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::create();

        //would we be able to access it
        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function an_authenticated_user_cannot_view_the_projects_of_others()
    {
        //grab an authenticated user
        $this->signIn();

        //grab a random project not created by the signed in user to make sure he cannot view it

        $project = factory('App\Project')->create();

        //and then we try to visit that project
        //check or assert if the status of the request would be 403
        $this->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_cannot_update_the_projects_of_others()
    {
        //grab an authenticated user
        $this->signIn();

        //grab a random project not created by the signed in user to make sure he cannot view it

        $project = factory('App\Project')->create();

        //and then we try to visit that project
        //check or assert if the status of the request would be 403
        $this->patch($project->path(), [])->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['title'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();
        $attributes = factory('App\Project')->raw(['description'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }

}
