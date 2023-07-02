<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     */
    public function created(Project $project): void
    {
        $project->saveActivity('created');
    }

    public function updating(Project $project): void
    {
        $project->old = [
            'title' => $project->getOriginal('title'),
            'description' => $project->getOriginal('description'),
            'notes' => $project->getOriginal('notes'),
        ];
    }

    /**
     * Handle the Project "updated" event.
     */
    public function updated(Project $project): void
    {
        $project->saveActivity('updated');
    }
}
