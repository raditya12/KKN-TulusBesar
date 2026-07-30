<?php

namespace App\Filament\Resources\VillageProfiles\Pages;

use App\Filament\Resources\VillageProfiles\VillageProfileResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVillageProfile extends EditRecord
{
    protected static string $resource = VillageProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
