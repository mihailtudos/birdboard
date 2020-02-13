<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects()->orderBy('created_at', 'desc')->get();


        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        //if the user is not the project owner he cannot see the project
        if (auth()->user()->isNot($project->owner)){
            abort(403);
        }

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
            'description' => 'required',
        ]);

        //persist

        $project = auth()->user()->projects()->create($attributes);


        //redirect
        return redirect( $project->path());
    }


}
