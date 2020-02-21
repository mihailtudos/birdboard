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
    public function only_the_owners_of__the_projects_can_invite_members()
    {
        $project = ProjectFactory::create();

        $user = factory(User::class)->create();

        //if you are not the owner of the project you cannot add other members
        $this->actingAs($user)
            ->post( $project->path() . '/invitations')
            ->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)
            ->post( $project->path() .'/invitations')
            ->assertStatus(403);
    }

    /** @test*/

    public function project_owner_can_invite_users()
    {

        $project = ProjectFactory::create();

        $invitedUser = factory(User::class)->create();

        $this->actingAs($project->owner)
            ->post( $project->path() . '/invitations', [
            'email' => $invitedUser->email])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($invitedUser));
    }

    /** @test*/
    public function the_invited_user_must_have_a_valid_account()
    {
        //given we have a project
        $project = ProjectFactory::create();

        //sign in as the owner of the project
        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
            'email' => 'notauser@example.com'
        ])->assertSessionHasErrors([
            'email' => 'The invited user does not have an account'
            ]);
    }

    /** @test*/

    public function project_members_can_update_project_details()
    {
        //given we have a project
        //the owner of the project invites another user
        //then the newly added user gets permissions to add tasks

        //factoring a project
        $project = ProjectFactory::create();

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
