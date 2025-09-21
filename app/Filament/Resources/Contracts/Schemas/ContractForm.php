<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ContractForm
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
                TextInput::make('role'),
                TextInput::make('payment_type'),
                TextInput::make('wage_rate')
                    ->numeric(),
                TextInput::make('advance_paid')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('total_paid')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('contact'),
            ]);
    }
}
