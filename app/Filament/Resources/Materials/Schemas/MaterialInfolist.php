<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Vendor;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('name'),
                TextEntry::make('unit')
                    ->placeholder('-'),
                TextEntry::make('unit_price')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('quantity_purchased')
                    ->numeric(),
                TextEntry::make('quantity_used')
                    ->numeric(),
                TextEntry::make('damaged_quantity')
                    ->numeric(),
                TextEntry::make('vendor.name')
                    ->label('Vendor')
                    ->placeholder('-'),
                TextEntry::make('purchase_date')
                    ->date()
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
