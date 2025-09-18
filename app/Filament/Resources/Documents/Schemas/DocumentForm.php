<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\Project;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required(),
                SpatieMediaLibraryFileUpload::make('file_path')
                    ->collection('documents')
                    ->required(),
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
                DateTimePicker::make('uploaded_at')
                    ->required(),
            ]);
    }
}
