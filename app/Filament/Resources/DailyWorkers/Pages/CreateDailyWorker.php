<?php

namespace App\Filament\Resources\DailyWorkers\Pages;

use App\Filament\Resources\DailyWorkers\DailyWorkerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDailyWorker extends CreateRecord
{
    protected static string $resource = DailyWorkerResource::class;
}
