<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class DailyReport extends Model
{
    use BelongsToProject;

    protected $guarded = ['id'];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function dailyWorkers(): HasMany
    {
        return $this->hasMany(DailyWorker::class);
    }

    public function expenses(): MorphMany
    {
        return $this->morphMany(Expense::class, 'expenseable');
    }

}
