<?php

namespace App\Filament\Resources\Materials\Schemas;

use App\Models\Material;
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
            ->columns(2)
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('unit')
                    ->options(Material::UNITS)
                    ->nullable(),
                TextInput::make('rate')
                    ->prefix('৳')
                    ->numeric(),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->nullable(),
                TextInput::make('quantity_available')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->hiddenOn('create'),
                TextInput::make('quantity_used')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->hiddenOn('create'),
                TextInput::make('quantity_damaged')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->hiddenOn('create'),

            ]);
    }
}
