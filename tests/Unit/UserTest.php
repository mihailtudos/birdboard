<?php

namespace Tests\Unit;

use App\User;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects()
    {
        //grab user
        $user = factory('App\User')->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }

    /** @test */
    public function a_user_has_accessable_projects()
    {
        $userOwner = $this->signIn();

        ProjectFactory::ownedBy($userOwner)->create();

        $this->assertCount(1,$userOwner->availableProjects());

        $userGuestOne = factory(User::class)->create();
        $userGuestTwo = factory(User::class)->create();

        $userGuestOneProjects = ProjectFactory::ownedBy($userGuestOne)->create();
        $userGuestOneProjects->invite($userGuestTwo);

        $this->assertCount(1,$userOwner->availableProjects());
        $userGuestOneProjects->invite($userOwner);
        $this->assertCount(2,$userOwner->availableProjects());

    }


}
