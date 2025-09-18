<?php

namespace App\Filament\Resources\LaborContractors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Project;

class LaborContractorForm
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
                Select::make('role')
                    ->options([
                        'mason' => 'Mason',
                        'electrician' => 'Electrician',
                        'plumber' => 'Plumber',
                        'carpenter' => 'Carpenter',
                        'painter' => 'Painter',
                        'other' => 'Other',
                    ])
                    ->nullable(),
                Select::make('payment_type')
                    ->options([
                        'daily_wage' => 'Daily Wage',
                        'contract' => 'Contract-based',
                    ])
                    ->nullable(),
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
