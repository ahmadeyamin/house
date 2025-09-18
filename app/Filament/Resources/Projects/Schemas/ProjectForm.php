<?php

namespace App\Filament\Resources\Projects\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('location'),
                TextInput::make('estimated_budget')
                    ->numeric(),
                DatePicker::make('start_date'),
                DatePicker::make('end_date'),
                TextInput::make('status')
                    ->required()
                    ->default('planned'),
            ]);
    }
}
