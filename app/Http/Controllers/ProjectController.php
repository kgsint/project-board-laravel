<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->accessibleProjects()
        ]);
    }

    public function show(Project $project)
    {
        // authorization
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $attributes = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'notes' => 'string|max:255'
        ],[
            '*.required' => 'The :attribute cannot be empty',
            ]
        );

        $project = auth()->user()->projects()->create($attributes);

        return redirect()->route('projects.show', $project->id);
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {

        $project->update($request->validated());

        return redirect()->route('projects.show', $project->id);
    }

    public function destroy(Project $project)
    {
        // authorize
        $this->authorize('manage', $project);

        $projectTitle = $project->title;

        $project->delete();

        return redirect()->route('projects.index')->with('status', "{$projectTitle} has been deleted");
    }
}
