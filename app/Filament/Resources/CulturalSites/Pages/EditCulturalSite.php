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

    public function getMaxContentWidth(): \Filament\Support\Enums\Width | string | null
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
