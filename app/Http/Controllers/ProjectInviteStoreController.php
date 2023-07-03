<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectInviteRequest;
use App\Models\Project;
use App\Models\User;

class ProjectInviteStoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Project $project, StoreProjectInviteRequest $request)
    {
        $this->authorize('update', $project);

        $request->validate([
            'email' => 'required|exists:users,email'
        ], [
            'email.exists' => 'The user you are inviting does not have an account',
        ]);

        $user = User::whereEmail($request->email)->first();

        $project->invite($user);

        return redirect($project->path())->with('status', 'Invitation sent');
    }
}
