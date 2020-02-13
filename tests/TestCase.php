<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signeIn($user = null)
    {
        //get a signed in user

        return  $this->actingAs($user ?: factory('App\User')->create());
    }
    public function getProject($project = null)
    {
        //get a project

        return  ($project ?: factory('App\Project')->create());
    }
}
