<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->columnSpanFull()
                    ->placeholder('Enter name')
                    ->label('Name'),
                Textarea::make('description')
                    ->columnSpanFull()
                    ->placeholder('Enter description')
                    ->label('Description'),
            ]);
    }
}
