<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('name'),
                TextEntry::make('unit')
                    ->placeholder('-'),
                TextEntry::make('rate')
                    ->numeric()
                    ->money('BDT')
                    ->placeholder('-'),
            
                TextEntry::make('transactions_sum_quantity')
                    ->label('Total Quantity Used')
                    ->sum([
                        'transactions' => function ($query) {
                            return $query->where('type', 'out');
                        }
                    ],'quantity')
                    ->numeric(),
                TextEntry::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),

                Stat::make('Total Material Cost', number_format($schema->getRecord()->transactions->where('type', 'in')->sum('total'),2) . ' BDT'),
                Stat::make('Total Material Quantity', number_format($schema->getRecord()->transactions->where('type', 'in')->sum('quantity'),2) . ' ' . $schema->getRecord()->unit),



                Stat::make('Total Expense', number_format($schema->getRecord()->expenses->sum('amount'),2) . ' BDT'),
                Stat::make('Total Count', $schema->getRecord()->expenses->count()),
            ]);
    }
}
