<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DailyReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                TextInput::make('weather'),
                Textarea::make('progress_notes')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('issues_notes')
                    ->columnSpanFull(),
            ]);
    }
}
