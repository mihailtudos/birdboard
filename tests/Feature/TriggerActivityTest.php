<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test*/

    public function creating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();
        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }
    /** @test*/

    public function updating_a_project_generates_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);

        // $this->assertEquals('created', $project->activity[0]->description);
    }

    /** @test*/

    public function creating_a_new_task_generates_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask('Some Task');

        $this->assertCount(2, $project->activity);

        $this->assertEquals('created task', $project->activity->last()->description);

    }

    /** @test*/

    public function completing_a_task_generates_project_activity()
    {
        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'something has been done',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->assertEquals('completed task', $project->activity->last()->description);

    }
    /** @test*/

    public function incomplete_a_task_generates_project_activity()
    {
        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
            'body' => 'something has been done',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
                'body' => 'something has been done',
                'completed' => false,
            ]);

        $project->refresh();
        $this->assertCount(4, $project->activity);
        $this->assertEquals('uncompleted task', $project->activity->last()->description);

    }

    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount( 3, $project->activity);

    }


}