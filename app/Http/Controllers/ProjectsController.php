<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{


    public function index()
    {
        $projects = auth()->user()->availableProjects();

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        //if the user is not the project owner he cannot see the project
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('/projects.create');
    }


    /**
     * Persist a new project.
     *
     * @return mixed
     */
    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());

        if (request()->has('tasks')){
            foreach (request('tasks') as $task){
                $project->addTask($task['body']);
            }
        }

        if (request()->wantsJson()) {
            return ['message' => $project->path()];
        }

        return redirect($project->path());
    }


    /**
     *
     * @param UpdateProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     */

    public function update(Project $project)
    {
        //if the user is not the project owner he cannot see the project
        $this->authorize('update', $project);

        $attributes = $this->validateRequest();

        $project->update($attributes);

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        //if the user is not the project owner he cannot see the project
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));

    }

    public function destroy(Project $project)
    {
        //a user cen delete a project only if he has management privileges (project policy)
        $this->authorize('manage', $project);
        $project->delete();
        return redirect('/projects');
    }


    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }

}
