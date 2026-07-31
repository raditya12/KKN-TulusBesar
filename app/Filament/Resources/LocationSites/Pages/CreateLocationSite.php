<?php

namespace App\Filament\Resources\LocationSites\Pages;

use App\Filament\Resources\LocationSites\LocationSiteResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateLocationSite extends CreateRecord
{
    protected static string $resource = LocationSiteResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['qr_code'])) {
            $data['qr_code'] = Str::random(6);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
