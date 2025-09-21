<?php

namespace App\Filament\Resources\Contracts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ContractInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('category.name')
                    ->label('Category')
                    ->placeholder('-'),
                TextEntry::make('contractor_name')
                    ->placeholder('-'),
                TextEntry::make('contractor_contact')
                    ->placeholder('-'),
                TextEntry::make('contract_budget')
                    ->numeric()
                    ->money('BDT')
                    ->placeholder('-'),
                TextEntry::make('start_date')
                    ->dateTime()
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('end_date')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('type')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
                Stat::make('Total Amount', number_format(
                    $schema->getRecord()->expenses->sum('amount')
                ) . ' BDT'),
                Stat::make('Number of Payments', $schema->getRecord()->expenses->count()),
            ]);
    }
}
