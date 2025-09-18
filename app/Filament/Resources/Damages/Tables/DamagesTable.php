<?php

namespace App\Filament\Resources\Damages\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Forms;

class DamagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('project.name')
                    ->label('Project')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('related_item_type')
                    ->searchable(),
                TextColumn::make('related_item_id')
                    ->sortable(),
                TextColumn::make('damage_cost')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('responsible_party')
                    ->searchable(),
                TextColumn::make('date')
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
                SelectFilter::make('related_item_type')
                    ->options([
                        'material' => 'Material',
                        'rental' => 'Rental Item',
                        'other' => 'Other',
                    ]),
                SelectFilter::make('responsible_party')
                    ->options([
                        'vendor' => 'Vendor',
                        'worker' => 'Worker',
                        'unknown' => 'Unknown',
                        'other' => 'Other',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('adjust_cost')
                    ->label('Adjust Cost')
                    ->icon('heroicon-o-pencil')
                    ->form([
                        TextInput::make('damage_cost')
                            ->label('Damage Cost')
                            ->required()
                            ->numeric(),
                    ])
                    ->action(function (Model $record, array $data): void {
                        $record->damage_cost = $data['damage_cost'];
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
