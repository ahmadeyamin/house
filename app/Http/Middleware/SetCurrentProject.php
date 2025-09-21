<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetCurrentProject
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::check()) {
            return $next($request);
        }

        $user = Auth::user();

        // Prefer persisted value
        $project = null;
        if ($user->current_project_id) {
            $project = $user->projects()->find($user->current_project_id);
        }

        // Fallback to session
        if (! $project && session('current_project_id')) {
            $project = $user->projects()->find(session('current_project_id'));
        }

        // Fallback to first project the user owns
        if (! $project) {
            $project = $user->projects()->orderBy('id')->first();

            if(!$project){
                // create
                $project = $user->projects()->create([
                    'name' => 'Default Project',
                ]);
            }
        }

        if ($project) {
            // Make it available on the user model and app container
            $user->setRelation('currentProject', $project);
            app()->instance('currentProject', $project);

            session(['current_project_id' => $project->id]);
        }

        return $next($request);
    }
}
