<?php

namespace App\Filament\Resources\LocationSites\Pages;

use App\Filament\Resources\LocationSites\LocationSiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLocationSites extends ListRecords
{
    protected static string $resource = LocationSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
