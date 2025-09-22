<?php

namespace App\Filament\Resources\Rents\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->label('Name'),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required()
                    ->label('Vendor'),
                DatePicker::make('start_date')
                    ->required()
                    ->label('Start Date'),
                DatePicker::make('end_date')
                    ->nullable()
                    ->label('End Date'),
                TextInput::make('rate')
                    ->required()
                    ->label('Rate')
                    ->numeric(),
                Select::make('billing_cycle')
                    ->required()
                    ->options(['daily' => 'Daily', 'weekly' => 'Weekly', 'monthly' => 'Monthly', 'usage' => 'Usage', 'fixed' => 'Fixed'])
                    ->label('Billing Cycle')
                    ->nullable(),
                TextInput::make('total_cost')
                    ->required()
                    ->label('Total Cost')
                    ->numeric(),
                Select::make('status')
                    ->required()
                    ->options(['active' => 'Active', 'returned' => 'Returned'])
                    ->default('active')
                    ->label('Status'),
                Textarea::make('details')
                    ->label('Details')
                    ->nullable()
                    ->columnSpan('full'),
            ]);
    }
}
