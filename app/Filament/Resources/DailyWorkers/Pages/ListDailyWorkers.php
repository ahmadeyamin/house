<?php

namespace App\Filament\Resources\DailyWorkers\Pages;

use App\Filament\Resources\DailyWorkers\DailyWorkerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDailyWorkers extends ListRecords
{
    protected static string $resource = DailyWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
