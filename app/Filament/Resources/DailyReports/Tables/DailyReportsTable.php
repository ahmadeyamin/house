<?php

namespace App\Filament\Resources\DailyReports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DailyReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('id')
                    ->sortable(),

                TextColumn::make('date')
                    ->date()
                    ->label('Report Date')
                    ->sortable(),
                TextColumn::make('weather')
                    ->searchable(),

                TextColumn::make('daily_workers_sum_worker_count')
                    ->label('Workers')
                    ->sum('dailyWorkers', 'worker_count')
                    ->default(0)
                    ->sortable(),
                TextColumn::make('expenses_sum_amount')
                    ->label('Total Expenses')
                    ->sum('expenses', 'amount')
                    ->money('BDT')
                    ->default(0)
                    ->sortable(),


                TextColumn::make('progress_notes')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
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
