<?php

namespace App\Filament\Resources\GisFeatures\Pages;

use App\Filament\Resources\GisFeatures\GisFeatureResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGisFeature extends CreateRecord
{
    protected static string $resource = GisFeatureResource::class;

    protected ?string $maxWidth = 'full';

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
