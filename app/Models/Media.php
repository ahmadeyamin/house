<?php


namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

class Media extends BaseMedia
{
    use BelongsToProject;

    protected $guarded = [

        'id'
    ];
}
