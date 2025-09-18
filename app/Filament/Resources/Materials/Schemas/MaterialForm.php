<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                Select::make('unit')
                    ->options([
                        'kg' => 'Kilogram (kg)',
                        'bag' => 'Bag',
                        'piece' => 'Piece',
                        'sqft' => 'Square Feet (sqft)',
                        'meter' => 'Meter',
                        'liter' => 'Liter',
                        'gallon' => 'Gallon',
                        'unit' => 'Unit',
                        'other' => 'Other',
                    ])
                    ->nullable(),
                TextInput::make('unit_price')
                    ->numeric(),
                TextInput::make('quantity_purchased')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('quantity_used')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('damaged_quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->nullable(),
                DatePicker::make('purchase_date'),
            ]);
    }
}
