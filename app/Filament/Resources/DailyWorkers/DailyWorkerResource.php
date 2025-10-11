<?php

namespace App\Filament\Resources\DailyWorkers;

use App\Filament\Resources\DailyWorkers\Pages\CreateDailyWorker;
use App\Filament\Resources\DailyWorkers\Pages\EditDailyWorker;
use App\Filament\Resources\DailyWorkers\Pages\ListDailyWorkers;
use App\Filament\Resources\DailyWorkers\Pages\ViewDailyWorker;
use App\Filament\Resources\DailyWorkers\Schemas\DailyWorkerForm;
use App\Filament\Resources\DailyWorkers\Schemas\DailyWorkerInfolist;
use App\Filament\Resources\DailyWorkers\Tables\DailyWorkersTable;
use App\Models\DailyWorker;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DailyWorkerResource extends Resource
{
    protected static ?string $model = DailyWorker::class;


    protected static ?int $navigationSort = 6;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'Daily Workers';

    public static function form(Schema $schema): Schema
    {
        return DailyWorkerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DailyWorkerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DailyWorkersTable::configure($table);
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
            'index' => ListDailyWorkers::route('/'),
            'create' => CreateDailyWorker::route('/create'),
            'view' => ViewDailyWorker::route('/{record}'),
            'edit' => EditDailyWorker::route('/{record}/edit'),
        ];
    }
}
