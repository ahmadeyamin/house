<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use BelongsToProject;


    protected $guarded = ['id'];



    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
