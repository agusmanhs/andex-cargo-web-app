<?php

namespace App\Filament\Resources\CorporateTariffResource\Pages;

use App\Filament\Resources\CorporateTariffResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCorporateTariffs extends ListRecords
{
    protected static string $resource = CorporateTariffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
