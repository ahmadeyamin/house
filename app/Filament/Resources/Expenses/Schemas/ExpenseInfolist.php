<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('expenseable.id')
                    ->label('Expenseable ID'),
                TextEntry::make('expenseable_type')
                    ->label('Expenseable Type'),
                TextEntry::make('category.name')
                    ->label('Category'),
                TextEntry::make('amount')
                    ->money('BDT')
                    ->label('Amount'),
                TextEntry::make('notes')
                    ->label('Note')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime('Y-m-d | h:i A')
                    ->label('Date'),
            ]);
    }
}
