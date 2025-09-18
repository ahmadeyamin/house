<?php

namespace App\Filament\Resources\LaborContractors;

use App\Filament\Resources\LaborContractors\Pages\CreateLaborContractor;
use App\Filament\Resources\LaborContractors\Pages\EditLaborContractor;
use App\Filament\Resources\LaborContractors\Pages\ListLaborContractors;
use App\Filament\Resources\LaborContractors\Pages\ViewLaborContractor;
use App\Filament\Resources\LaborContractors\Schemas\LaborContractorForm;
use App\Filament\Resources\LaborContractors\Schemas\LaborContractorInfolist;
use App\Filament\Resources\LaborContractors\Tables\LaborContractorsTable;
use App\Models\LaborContractor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LaborContractorResource extends Resource
{
    protected static ?string $model = LaborContractor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Labor Contractor';

    public static function form(Schema $schema): Schema
    {
        return LaborContractorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LaborContractorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LaborContractorsTable::configure($table);
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
            'index' => ListLaborContractors::route('/'),
            'create' => CreateLaborContractor::route('/create'),
            'view' => ViewLaborContractor::route('/{record}'),
            'edit' => EditLaborContractor::route('/{record}/edit'),
        ];
    }
}
