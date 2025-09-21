<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    protected $guarded = ['id'];


    protected static function booted()
    {
        static::creating(function ($project) {
            if (Auth::check()) {
                $project->user_id = Auth::id();
            }
        });
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
