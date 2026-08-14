<?php

namespace App\Filament\Resources\VillageDocuments\Pages;

use App\Filament\Resources\VillageDocuments\VillageDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVillageDocuments extends ListRecords
{
    protected static string $resource = VillageDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
