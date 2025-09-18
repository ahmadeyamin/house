<?php

namespace App\Filament\Resources\RentalItems\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;

class RentalItemInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('item_name'),
                TextEntry::make('vendor.name')
                    ->label('Vendor'),
                TextEntry::make('rent_start_date')
                    ->date(),
                TextEntry::make('rent_end_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('rent_cost_per_day')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('total_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('damage_cost')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
