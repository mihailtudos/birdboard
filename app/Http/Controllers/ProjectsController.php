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
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required|max:200',
            'notes' => 'min:3|max:255',
        ]);

        //persist

        $project = auth()->user()->projects()->create($attributes);


        //redirect
        return redirect( $project->path());
    }

    public function update(Project $project)
    {
        //if the user is not the project owner he cannot see the project
        $this->authorize('update', $project);

        $project->update(\request(['notes']));

        return redirect($project->path());
    }


}
