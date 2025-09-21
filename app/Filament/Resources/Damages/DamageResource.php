<?php

namespace App\Filament\Resources\Damages;

use App\Filament\Resources\Damages\Pages\CreateDamage;
use App\Filament\Resources\Damages\Pages\EditDamage;
use App\Filament\Resources\Damages\Pages\ListDamages;
use App\Filament\Resources\Damages\Pages\ViewDamage;
use App\Filament\Resources\Damages\Schemas\DamageForm;
use App\Filament\Resources\Damages\Schemas\DamageInfolist;
use App\Filament\Resources\Damages\Tables\DamagesTable;
use App\Models\Damage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DamageResource extends Resource
{
    protected static ?string $model = Damage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Scissors;

    protected static ?string $recordTitleAttribute = 'Damage';

    public static function form(Schema $schema): Schema
    {
        return DamageForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DamageInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DamagesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDamages::route('/'),
            'create' => CreateDamage::route('/create'),
            'view' => ViewDamage::route('/{record}'),
            'edit' => EditDamage::route('/{record}/edit'),
        ];
    }
}
