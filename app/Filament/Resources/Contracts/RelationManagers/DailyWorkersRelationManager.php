<?php

namespace App\Filament\Resources\Contracts\RelationManagers;

use App\Filament\Resources\DailyReports\DailyReportResource;
use App\Models\Contract;
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
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DailyWorkersRelationManager extends RelationManager
{
    protected static string $relationship = 'dailyWorkers';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),

                DatePicker::make('date')
                    ->required()
                    ->default(now()),


                TextInput::make('worker_count')
                    ->required()
                    ->numeric(),

                TextInput::make('hours_worked')
                    ->numeric(),

                TextInput::make('total_cost')
                    ->numeric()
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('worker_count')
                    ->numeric(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('hours_worked')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('date')
                    ->label('Report date')
                    ->url(fn ($record) => DailyReportResource::getUrl('view', ['record' => $record->dailyReport]))
                    ->date()
                    ->sortable(),

                TextColumn::make('worker_count')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('hours_worked')
                    ->numeric()
                    ->sortable()
                    ->default('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('total_cost')
                    ->numeric()
                    ->sortable()
                    ->money('BDT')
                    ->default(0),
                TextColumn::make('notes')
                    ->sortable()
                    ->default('-'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // CreateAction::make(),
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
