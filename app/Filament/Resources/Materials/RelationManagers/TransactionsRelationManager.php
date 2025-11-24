<?php

namespace App\Filament\Resources\Materials\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    // title
    protected static ?string $title = 'Buy and use quantity';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                ToggleButtons::make('type')
                    ->options([
                        'in' => 'Add Material',
                        'out' => 'Subtract Material',
                    ])
                    ->colors([
                        'in' => 'success',
                        'out' => 'danger',
                    ])
                    ->icons([
                        'in' => Heroicon::OutlinedPlus,
                        'out' => Heroicon::OutlinedMinus,
                    ])
                    ->label('Type')
                    ->default('in')
                    ->grouped()
                    ->required()
                    ->columnSpanFull()
                    ->disabledOn('edit'),

                TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->prefix(function ($livewire) {
                        return $livewire->getOwnerRecord()->unit;
                    })
                    ->columns(),

                TextInput::make('rate')
                    ->numeric()
                    ->columns()
                    ->default(function ($livewire) {
                        return $livewire->getOwnerRecord()->rate;
                    })
                    ->prefix('৳'),

                DatePicker::make('date')
                    ->required()
                    ->default(now()),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('quantity')
                    ->numeric(),
                TextEntry::make('rate')
                    ->numeric()
                    ->money('BDT'),
                TextEntry::make('type')
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'in' => 'success',
                            'out' => 'danger',
                        };
                    })
                    ->icon(function ($state) {
                        return match ($state) {
                            'in' => Heroicon::OutlinedPlus,
                            'out' => Heroicon::OutlinedMinus,
                        };
                    }),

                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),

                TextEntry::make('date')
                    ->date(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('rate')
                    ->numeric()
                    ->money('BDT')
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('type')
                    ->searchable()
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            'in' => 'success',
                            'out' => 'danger',
                        };
                    })
                    ->icon(function ($state) {
                        return match ($state) {
                            'in' => Heroicon::OutlinedPlus,
                            'out' => Heroicon::OutlinedMinus,
                        };
                    }),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('notes')->label('Notes'),
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
            ->headerActions([
                CreateAction::make()
                    ->mutateDataUsing(function (array $data): array {
                        if ($data['type'] == 'in') {
                            $data['total'] = $data['quantity'] * $data['rate'];
                        } else {
                            $data['rate'] = null;
                            $data['total'] = null;
                        }

                        return $data;
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
