<?php

namespace App\Models;

use App\Models\Traits\BelongsToProject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Material extends Model
{

    use BelongsToProject;

    protected $guarded = ['id'];

    CONST UNITS = [
        'kg' => 'Kilogram (kg)',
        'ton' => 'Ton',
        'bag' => 'Bag',
        'piece' => 'Piece',
        'ft' => 'Foot (ft)',
        'sqft' => 'Square Feet (sqft)',
        'meter' => 'Meter',
        'liter' => 'Liter',
        'gallon' => 'Gallon',
        'unit' => 'Unit',
        'other' => 'Other',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function expenses()
    {
        return $this->morphMany(Expense::class, 'expenseable');
    }

    public function transactions()
    {
        return $this->hasMany(MaterialTransaction::class);
    }
}
