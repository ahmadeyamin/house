<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                Select::make('payment_type')
                    ->options([
                        'advance' => 'Advance Payment',
                        'product' => 'Product Purchase',
                        'service' => 'Service Payment',
                        'rent' => 'Rental Item Payment',
                        'other' => 'Other',
                    ])
                    ->required(),
                Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->nullable(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                DatePicker::make('payment_date')
                    ->required(),
                Select::make('status')
                    ->options([
                        'paid' => 'Paid',
                        'pending' => 'Pending',
                        'partial' => 'Partial',
                    ])
                    ->required()
                    ->default('pending'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
