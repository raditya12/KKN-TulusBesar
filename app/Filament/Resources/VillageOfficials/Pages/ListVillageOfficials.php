<?php

namespace App\Filament\Resources\VillageOfficials\Pages;

use App\Filament\Resources\VillageOfficials\VillageOfficialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVillageOfficials extends ListRecords
{
    protected static string $resource = VillageOfficialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
