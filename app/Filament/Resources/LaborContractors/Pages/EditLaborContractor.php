<?php

namespace App\Filament\Resources\LaborContractors\Pages;

use App\Filament\Resources\LaborContractors\LaborContractorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLaborContractor extends EditRecord
{
    protected static string $resource = LaborContractorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
