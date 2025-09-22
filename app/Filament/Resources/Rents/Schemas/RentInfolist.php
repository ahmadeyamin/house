<?php

namespace App\Filament\Resources\Rents\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Name'),
                TextEntry::make('vendor.name')
                    ->label('Vendor'),
                TextEntry::make('start_date')
                    ->label('Start Date'),
                TextEntry::make('end_date')
                    ->label('End Date'),
                TextEntry::make('rate')
                    ->label('Rate'),
                TextEntry::make('billing_cycle')
                    ->label('Billing Cycle'),
                TextEntry::make('total_cost')
                    ->label('Total Cost')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Status')
                    ->placeholder('-'),
                TextEntry::make('details')
                    ->label('Details')
                    ->columnSpanFull()
                    ->placeholder('-'),



                Stat::make('Total Expense', number_format($schema->getRecord()->expenses->sum('amount'), 2) . ' BDT'),
                Stat::make('Number of Expenses', $schema->getRecord()->expenses->count()),
            ]);
    }
}
