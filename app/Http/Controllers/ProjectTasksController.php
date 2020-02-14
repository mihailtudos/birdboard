<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTasksController extends Controller
{
    /**
     * Add a task to the given project
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Project $project)
    {
//        if the auth user is not the owner of the project aboard
        $this->authorize('update', $project);

        request()->validate([
            'body' => 'required',
        ]);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {

        //if the auth user is not the owner of the project aboard
       $this->authorize('update', $project);

        request()->validate([
            'body' => 'required'
        ]);

        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);


        return redirect($project->path());

    }
}
