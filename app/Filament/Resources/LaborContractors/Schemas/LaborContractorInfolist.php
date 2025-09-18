<?php

namespace App\Filament\Resources\LaborContractors\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use App\Models\Project;

class LaborContractorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('project.name')
                    ->label('Project'),
                TextEntry::make('name'),
                TextEntry::make('role')
                    ->placeholder('-'),
                TextEntry::make('payment_type')
                    ->placeholder('-'),
                TextEntry::make('wage_rate')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('advance_paid')
                    ->numeric(),
                TextEntry::make('total_paid')
                    ->numeric(),
                TextEntry::make('contact')
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
