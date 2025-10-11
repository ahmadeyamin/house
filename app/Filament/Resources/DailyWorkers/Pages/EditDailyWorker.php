<?php

namespace App\Filament\Resources\DailyWorkers\Pages;

use App\Filament\Resources\DailyWorkers\DailyWorkerResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDailyWorker extends EditRecord
{
    protected static string $resource = DailyWorkerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
