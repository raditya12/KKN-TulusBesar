<?php

namespace App\Filament\Resources\VillageDocuments\Pages;

use App\Filament\Resources\VillageDocuments\VillageDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVillageDocument extends EditRecord
{
    protected static string $resource = VillageDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
