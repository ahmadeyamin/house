<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('contact_info'),
                Select::make('type')
                    ->options([
                        'shop' => 'shop',
                        'supplier' => 'Supplier',
                        'Contract' => 'Contract',
                        'rental' => 'Rental Company',
                        'labor' => 'Labor',
                        'other' => 'Other',
                    ])
                    ->nullable(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
