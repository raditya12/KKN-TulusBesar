<?php

namespace App\Filament\Resources\CulturalSites\Pages;

use App\Filament\Resources\CulturalSites\CulturalSiteResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCulturalSite extends CreateRecord
{
    protected static string $resource = CulturalSiteResource::class;

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return 'full';
    }

    public function hasFullWidthFormActions(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
