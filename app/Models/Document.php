<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Document extends Model implements HasMedia
{
    use InteractsWithMedia;

    use BelongsToProject;

    protected $fillable = [
        'project_id',
        'file_path',
        'type',
        'uploaded_at',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
