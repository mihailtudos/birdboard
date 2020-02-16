<?php


namespace Tests\Setup;


use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{

    protected $tasksCount = 0;
    protected $user;

    public function withTask($count)
    {
        $this->tasksCount = $count;

        return $this;
    }

    public function ownedBy($user)
    {
        $this->user = $user;

        return $user;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->user ?? factory(User::class)->create(),
        ]);

        factory(Task::class, $this->tasksCount)->create([
            'project_id' => $project->id
        ]);

        return $project;
    }
}
