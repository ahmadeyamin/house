<?php

namespace App\Filament\Resources\RentalItems\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class RentalItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('item_name')
                    ->searchable(),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('rent_start_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('rent_end_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('rent_cost_per_day')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('total_cost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->searchable(),
                TextColumn::make('damage_cost')
                    ->numeric()
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
            ->filters([
                SelectFilter::make('project_id')
                    ->relationship('project', 'name'),
                SelectFilter::make('vendor_id')
                    ->relationship('vendor', 'name'),
                SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'returned' => 'Returned',
                        'damaged' => 'Damaged',
                    ]),
                Filter::make('due_soon')
                    ->query(fn (Builder $query): Builder => $query->where('rent_end_date', '<=', Carbon::now()->addDays(7)))
                    ->label('Due Soon'),
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('mark_returned')
                    ->label('Mark Returned')
                    ->icon('heroicon-o-check')
                    ->requiresConfirmation()
                    ->action(function (Model $record): void {
                        $record->status = 'returned';
                        $record->save();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
