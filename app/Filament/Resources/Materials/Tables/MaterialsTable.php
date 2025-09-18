<?php

namespace App\Filament\Resources\Materials\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('unit')
                    ->searchable(),
                TextColumn::make('unit_price')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity_purchased')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('quantity_used')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('damaged_quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('purchase_date')
                    ->date()
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
                SelectFilter::make('unit')
                    ->options([
                        'kg' => 'Kilogram (kg)',
                        'bag' => 'Bag',
                        'piece' => 'Piece',
                        'sqft' => 'Square Feet (sqft)',
                        'meter' => 'Meter',
                        'liter' => 'Liter',
                        'gallon' => 'Gallon',
                        'unit' => 'Unit',
                        'other' => 'Other',
                    ]),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('mark_used')
                    ->label('Mark Used')
                    ->icon('heroicon-o-check-circle')
                    ->requiresConfirmation()
                    ->action(function (Model $record): void {
                        $record->quantity_used = $record->quantity_purchased;
                        $record->save();
                    }),
                Action::make('mark_damaged')
                    ->label('Mark Damaged')
                    ->icon('heroicon-o-exclamation-circle')
                    ->requiresConfirmation()
                    ->action(function (Model $record): void {
                        $record->damaged_quantity = $record->quantity_purchased - $record->quantity_used;
                        $record->save();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
