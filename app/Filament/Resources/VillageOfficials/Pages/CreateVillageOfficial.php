<?php

namespace App\Filament\Resources\VillageOfficials\Pages;

use App\Filament\Resources\VillageOfficials\VillageOfficialResource;
use Filament\Resources\Pages\CreateRecord;

class CreateVillageOfficial extends CreateRecord
{
    protected static string $resource = VillageOfficialResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
