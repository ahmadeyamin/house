<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;

class materialTransaction extends Model
{

      use BelongsToProject;

    protected $guarded = ['id'];


     public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
