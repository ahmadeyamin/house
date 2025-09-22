<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use BelongsToProject;

    protected $guarded = ['id'];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }
}
