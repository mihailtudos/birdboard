<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user = null)
    {
        //get a signed in user

        $user = $user ?: factory('App\User')->create();

        $this->actingAs($user);

        return $user;
    }
    public function getProject($project = null)
    {
        //get a project

        return  ($project ?: factory('App\Project')->create());
    }


}
