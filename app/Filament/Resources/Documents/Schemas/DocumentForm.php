<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use App\Models\Project;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('file_path')
                ->collection('documents')
                ->required()
                ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('type')
                    ->options([
                        'invoice' => 'Invoice',
                        'contract' => 'Contract',
                        'receipt' => 'Receipt',
                        'drawing' => 'Drawing',
                        'progress-photo' => 'Progress Photo',
                        'other' => 'Other',
                    ])
                ->nullable(),
            ]);
    }
}
