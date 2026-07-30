<?php

namespace App\Filament\Resources\VillageProfiles\Pages;

use App\Filament\Resources\VillageProfiles\VillageProfileResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVillageProfiles extends ListRecords
{
    protected static string $resource = VillageProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
