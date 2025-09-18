<?php

namespace App\Filament\Resources\LaborContractors\Pages;

use App\Filament\Resources\LaborContractors\LaborContractorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLaborContractors extends ListRecords
{
    protected static string $resource = LaborContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
