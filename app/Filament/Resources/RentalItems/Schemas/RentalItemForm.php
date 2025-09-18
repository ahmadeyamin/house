<?php

namespace App\Filament\Resources\RentalItems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;

class RentalItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                TextInput::make('item_name')
                    ->required(),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required(),
                DatePicker::make('rent_start_date')
                    ->required(),
                DatePicker::make('rent_end_date'),
                TextInput::make('rent_cost_per_day')
                    ->numeric(),
                TextInput::make('total_cost')
                    ->numeric(),
                Select::make('status')
                    ->options([
                        'active' => 'Active',
                        'returned' => 'Returned',
                        'damaged' => 'Damaged',
                    ])
                    ->required()
                    ->default('active'),
                TextInput::make('damage_cost')
                    ->numeric(),
            ]);
    }
}
