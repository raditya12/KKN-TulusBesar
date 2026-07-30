<?php

namespace App\Filament\Resources\CulturalSites\Pages;

use App\Filament\Resources\CulturalSites\CulturalSiteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCulturalSite extends EditRecord
{
    protected static string $resource = CulturalSiteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
