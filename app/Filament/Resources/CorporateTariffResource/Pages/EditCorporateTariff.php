<?php

namespace App\Filament\Resources\CorporateTariffResource\Pages;

use App\Filament\Resources\CorporateTariffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCorporateTariff extends EditRecord
{
    protected static string $resource = CorporateTariffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
