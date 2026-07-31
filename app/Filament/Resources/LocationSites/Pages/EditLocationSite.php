<?php

namespace App\Filament\Resources\LocationSites\Pages;

use App\Filament\Resources\LocationSites\LocationSiteResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditLocationSite extends EditRecord
{
    protected static string $resource = LocationSiteResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
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

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
