<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{


    public function index()
    {
        $projects = auth()->user()->projects;


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

    public function store()
    {
        //validate
        $attributes = $this->validateRequest();

        //persist

        $project = auth()->user()->projects()->create($attributes);


        //redirect
        return redirect( $project->path());
    }

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

    /**
     * @return array
     */

    protected function validateRequest()
    {
        return $attributes = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required|max:200',
            'notes' => 'nullable|max:255',
        ]);
    }


}
