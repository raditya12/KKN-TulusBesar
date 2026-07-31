<?php

namespace App\Filament\Resources\VillageOfficials\Pages;

use App\Filament\Resources\VillageOfficials\VillageOfficialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVillageOfficial extends EditRecord
{
    protected static string $resource = VillageOfficialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
