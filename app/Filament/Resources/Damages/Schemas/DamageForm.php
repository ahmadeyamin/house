<?php

namespace App\Filament\Resources\Damages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Material;
use App\Models\RentalItem;
use Illuminate\Database\Eloquent\Builder;

class DamageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Select::make('material_id')
                    ->relationship('material', 'name')
                    ->required(),
                TextInput::make('damage_cost')
                    ->numeric()
                    ->prefix('৳')
                    ->required(),
                DatePicker::make('date')
                    ->default(now())
                    ->required()
                    ->columns(1),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}
