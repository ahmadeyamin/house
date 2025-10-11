<?php

namespace App\Filament\Resources\DailyWorkers\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DailyWorkerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('dailyReport.date')
                    ->date()
                    ->label('Daily report'),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('worker_count')
                    ->numeric(),
                TextEntry::make('hours_worked')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total_cost')
                    ->numeric()
                    ->money('BDT')
                    ->placeholder('-'),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('contract.name')
                    ->label('Contract')
                    ->placeholder('-'),
            ]);
    }
}
