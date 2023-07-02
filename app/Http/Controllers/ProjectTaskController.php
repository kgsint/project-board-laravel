<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function store(Project $project, Request $request)
    {
        // authorization
        $this->authorize('update', $project);

        $request->validate([
            'body' => 'required'
        ]);


        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {
        // authorization
        $this->authorize('update', $project);

        $task->update([
            'body' => request('body'),
        ]);

        request('completed') ? $task->complete() : $task->incomplete();

        return redirect()->route('projects.show', $project->id);
    }
}
