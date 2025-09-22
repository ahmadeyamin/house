<?php

namespace App\Filament\Resources\Documents\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;


class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                SpatieMediaLibraryFileUpload::make('media')
                    ->collection('documents'),
                TextEntry::make('description')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
