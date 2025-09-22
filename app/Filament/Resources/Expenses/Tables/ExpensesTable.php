<?php

namespace App\Filament\Resources\Expenses\Tables;

use App\Models\Contract;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Vendor;
use App\Models\Project;
use App\Models\Rent;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('expenseable.name')
                    ->label('Expenseable'),
                TextColumn::make('expenseable_type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        Material::class => 'Material',
                        Contract::class => 'Contract',
                        Rent::class => 'Rent',
                        default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        Material::class => 'success',
                        Contract::class => 'warning',
                        Rent::class => 'primary',
                        default => 'primary',
                    })
                    ->label('Type'),
                TextColumn::make('category.name')
                    ->label('Category'),
                TextColumn::make('amount')
                    ->money('BDT')
                    ->label('Amount'),
                TextColumn::make('method')
                    ->label('Method'),
                TextColumn::make('notes')
                    ->label('Note')
                    ->placeholder('-'),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d | h:i A')
                    ->label('Date'),
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
