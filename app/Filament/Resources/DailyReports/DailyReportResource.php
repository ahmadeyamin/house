<?php

namespace App\Filament\Resources\DailyReports;

use App\Filament\Resources\DailyReports\Pages\CreateDailyReport;
use App\Filament\Resources\DailyReports\Pages\EditDailyReport;
use App\Filament\Resources\DailyReports\Pages\ListDailyReports;
use App\Filament\Resources\DailyReports\Pages\ViewDailyReport;
use App\Filament\Resources\DailyReports\RelationManagers\DailyWorkersRelationManager;
use App\Filament\Resources\DailyReports\RelationManagers\ExpensesRelationManager;
use App\Filament\Resources\DailyReports\Schemas\DailyReportForm;
use App\Filament\Resources\DailyReports\Schemas\DailyReportInfolist;
use App\Filament\Resources\DailyReports\Tables\DailyReportsTable;
use App\Models\DailyReport;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DailyReportResource extends Resource
{
    protected static ?string $model = DailyReport::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CalendarDays;

    protected static ?string $recordTitleAttribute = 'Daily Reports';

    public static function form(Schema $schema): Schema
    {
        return DailyReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DailyReportInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DailyReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            DailyWorkersRelationManager::class,
            ExpensesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDailyReports::route('/'),
            'create' => CreateDailyReport::route('/create'),
            'view' => ViewDailyReport::route('/{record}'),
            'edit' => EditDailyReport::route('/{record}/edit'),
        ];
    }
}
