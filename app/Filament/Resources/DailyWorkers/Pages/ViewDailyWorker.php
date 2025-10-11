<?php

namespace App\Filament\Resources\DailyWorkers\Pages;

use App\Filament\Resources\DailyWorkers\DailyWorkerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDailyWorker extends ViewRecord
{
    protected static string $resource = DailyWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
