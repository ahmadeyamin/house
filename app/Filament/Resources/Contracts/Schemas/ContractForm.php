<?php

namespace App\Filament\Resources\Contracts\Schemas;

use App\Models\Contract;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Main details section, full width
                Section::make('Core Information')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Contract Name')
                            ->required()
                            ->columnSpanFull(), // Take up the full width of the section

                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        TextInput::make('contract_budget')
                            ->label('Budget')
                            ->numeric()
                            ->prefix('৳') // Or your currency symbol
                            ->required()
                            ->default(0),
                    ]),

                // Contractor details section
                Section::make('Contractor Details')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contractor_name')
                            ->label('Contractor Name')
                            ->required(),

                        TextInput::make('contractor_contact')
                            ->label('Contractor Contact')
                            ->tel()
                            ->name('contractor_contact')
                            ->placeholder('e.g., email or phone number'),
                    ]),

                // Timeline and Status section
                Section::make('Timeline & Status')
                    ->columns(2)
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),

                        DatePicker::make('end_date')
                            // Ensure end date is not before the start date
                            ->after('start_date'),

                        Select::make('type')
                            ->label('Type')
                            ->options(Contract::TYPES)
                            ->native(false) // Use a better looking select dropdown
                            ->required(),

                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'pending' => 'Pending',
                                'active' => 'Active',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->native(false) // Use a better looking select dropdown
                            ->required(),
                    ]),

                // Description at the bottom, full width
                Section::make('Description')
                    ->schema([
                        Textarea::make('description')
                            ->label('Contract Description & Notes')
                            ->rows(5)
                            ->columnSpanFull(), // Take up the full width
                    ]),
            ]);
    }
}
