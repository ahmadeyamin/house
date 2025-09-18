<?php

namespace App\Filament\Resources\LaborContractors\Pages;

use App\Filament\Resources\LaborContractors\LaborContractorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLaborContractor extends ViewRecord
{
    protected static string $resource = LaborContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
