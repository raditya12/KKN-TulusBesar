<?php

namespace App\Filament\Resources\CulturalSites\Pages;

use App\Filament\Resources\CulturalSites\CulturalSiteResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateCulturalSite extends CreateRecord
{
    protected static string $resource = CulturalSiteResource::class;

    protected ?string $maxWidth = 'full';

    public function hasFullWidthFormActions(): bool
    {
        return true;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
