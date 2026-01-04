<?php

namespace App\Filament\Resources\DailyWorkers\Tables;

use App\Models\Contract;
use App\Models\DailyWorker;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Count;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class DailyWorkersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('dailyReport.date')
                    ->date()
                    ->url(fn(DailyWorker $record) => route('filament.admin.resources.daily-reports.view', $record->daily_report_id))
                    ->label('Report date')
                    ->sortable(),
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('contract.name')
                    ->url(fn(DailyWorker $record) => route('filament.admin.resources.contracts.view', $record->contract_id))
                    ->searchable(),
                TextColumn::make('date')
                    ->date()
                    ->toggleable(isToggledHiddenByDefault: true)
                    // ->summarize(Count::make('date')->label('Count'))
                    ->sortable(),
                TextColumn::make('worker_count')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()->label('Total')),
                TextColumn::make('hours_worked')
                    ->numeric()
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->numeric()
                    ->money('BDT')
                    ->default(0)
                    ->sortable(),
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
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                SelectFilter::make('contract')
                    ->relationship('contract', 'name'),
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
