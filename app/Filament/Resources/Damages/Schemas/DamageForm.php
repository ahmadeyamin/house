<?php

namespace App\Filament\Resources\Damages\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Project;
use App\Models\Material;
use App\Models\RentalItem;
use Illuminate\Database\Eloquent\Builder;

class DamageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('project_id')
                    ->relationship('project', 'name')
                    ->required()
                    ->live(),
                Select::make('related_item_type')
                    ->options([
                        'material' => 'Material',
                        'rental' => 'Rental Item',
                        'other' => 'Other',
                    ])
                    ->nullable()
                    ->live(),
                Select::make('related_item_id')
                    ->label('Related Item')
                    ->options(function (callable $get) {
                        $type = $get('related_item_type');
                        $projectId = $get('project_id');

                        if (!$type || !$projectId) {
                            return [];
                        }

                        if ($type === 'material') {
                            return Material::where('project_id', $projectId)->pluck('name', 'id');
                        }

                        if ($type === 'rental') {
                            return RentalItem::where('project_id', $projectId)->pluck('item_name', 'id');
                        }

                        return [];
                    })
                    ->nullable(),
                Textarea::make('description')
                    ->columnSpanFull(),
                TextInput::make('damage_cost')
                    ->numeric(),
                Select::make('responsible_party')
                    ->options([
                        'vendor' => 'Vendor',
                        'worker' => 'Worker',
                        'unknown' => 'Unknown',
                        'other' => 'Other',
                    ])
                    ->nullable(),
                DatePicker::make('date')
                    ->required(),
            ]);
    }
}
