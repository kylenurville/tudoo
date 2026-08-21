<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    // Opens the Projects index page
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    // Saves a project to database
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $project        = new Project();
        $project->name  = $request->name;
        $project->save();

        return back();
    }

    // Updates a project
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255']
        ]);

        $project->name  = $request->name;
        $project->save();

        return back();
    }

    // Deletes a project
    public function destroy(Project $project)
    {
        $project->delete();
        return back();
    }
}
