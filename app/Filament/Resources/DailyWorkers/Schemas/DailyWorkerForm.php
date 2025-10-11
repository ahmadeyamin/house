<?php

namespace App\Filament\Resources\DailyWorkers\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DailyWorkerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('daily_report_id')
                    ->relationship('dailyReport', 'id')
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                DatePicker::make('date')
                    ->required(),
                TextInput::make('worker_count')
                    ->required()
                    ->numeric(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('hours_worked')
                    ->numeric(),
                TextInput::make('total_cost')
                    ->numeric(),
                Select::make('contract_id')
                    ->relationship('contract', 'name'),
            ]);
    }
}
