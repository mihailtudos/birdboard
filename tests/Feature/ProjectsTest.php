<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectsTest extends TestCase
{
    /*a test to start with
    from the outside to inside */
    use WithFaker, RefreshDatabase;

     /** @test */
    public function a_user_can_create_a_project()
    {   //disable error handling
        $this->withoutExceptionHandling();

        //the attributes we are working with are going to be saved in an array
        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
        ];
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertRedirect('/projects');

        //I should have a database record containing the attributes send at previous step
        $this->assertDatabaseHas('projects', $attributes);

        //Would I see a the title of a project if I would access /projects
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $attributes = factory('App\Project')->raw(['title'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('title');

    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $attributes = factory('App\Project')->raw(['description'=>'']);
        //if I submit a post request with to the specified address and send the attributes
        $this->post('/projects', $attributes)->assertSessionHasErrors('description');

    }

}
