<?php

namespace App\Filament\Resources\CulturalSites\Pages;

use App\Filament\Resources\CulturalSites\CulturalSiteResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCulturalSites extends ListRecords
{
    protected static string $resource = CulturalSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
