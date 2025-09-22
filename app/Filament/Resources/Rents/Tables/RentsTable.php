<?php

namespace App\Filament\Resources\Rents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('vendor.name')
                    ->searchable(),
                TextColumn::make('start_date')
                    ->date()
                    ->searchable(),
                TextColumn::make('end_date')
                    ->date()
                    ->searchable(),
                TextColumn::make('rate')
                    ->money('BDT')
                    ->searchable(),
                TextColumn::make('expenses_sum_amount')
                    ->label('Total Paid')
                    ->sum('expenses', 'amount')
                    ->money('BDT')
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->money('BDT')
                    ->searchable(),
                TextColumn::make('status')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
