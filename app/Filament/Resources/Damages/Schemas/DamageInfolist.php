<?php

namespace App\Filament\Resources\Damages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Material;
use App\Models\RentalItem;

class DamageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('related_item_type')
                    ->placeholder('-'),
                TextEntry::make('related_item_id')
                    ->placeholder('-'),
                TextEntry::make('description')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('damage_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('responsible_party')
                    ->placeholder('-'),
                TextEntry::make('date')
                    ->date(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
