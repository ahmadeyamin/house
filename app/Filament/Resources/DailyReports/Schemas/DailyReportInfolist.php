<?php

namespace App\Filament\Resources\DailyReports\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;
use Str;

class DailyReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('weather')
                    ->placeholder('-')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('progress_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('issues_notes')
                    ->placeholder('-')
                    ->columnSpanFull(),

                Stat::make('Total worker', $schema->getRecord()->dailyWorkers->sum('worker_count'))->columns(),
                Stat::make('Total Expenses', Number::currency($schema->getRecord()->expenses->sum('amount'))),
            ]);
    }
}
