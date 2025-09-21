<?php

namespace App\Models\Traits;

use App\Models\Scopes\ProjectScope;
use Illuminate\Support\Facades\Auth;

trait BelongsToProject
{
    protected static function bootBelongsToProject(): void
    {
        static::addGlobalScope(new ProjectScope);

        static::creating(function ($model) {

            $project = Auth::user()->currentProject;

            if ($project) {
                $model->project_id = $project->id;

                if (!in_array('user_id', $model->getFillable())) {
                    return;
                }

                if ($project) {
                    $model->user_id = $project->user_id;
                }
            }
        });
    }
}
