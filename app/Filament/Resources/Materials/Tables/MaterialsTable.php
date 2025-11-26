<?php

namespace App\Filament\Resources\Materials\Tables;

use App\Models\Material;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Summarizers\Sum;
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
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('unit')
                    ->badge()
                    ->searchable(),
                TextColumn::make('rate')
                    ->money('BDT')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('transactions_sum_quantity')
                    ->sum([
                        'transactions' => function ($query) {
                            return $query->where('type', 'in');
                        }
                    ], 'quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('expenses_sum_amount')
                    ->sum('expenses', 'amount')
                    ->label('Total Cost')
                    ->numeric()
                    ->money('BDT')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('vendor.name')
                    ->label('Vendor')
                    ->searchable()
                    ->placeholder('-')
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
                SelectFilter::make('project_id')
                    ->relationship('project', 'name'),
                SelectFilter::make('vendor_id')
                    ->relationship('vendor', 'name'),
                SelectFilter::make('unit')
                    ->options(Material::UNITS),
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
