<?php

namespace App\Filament\Resources\VillageHistories\Pages;

use App\Filament\Resources\VillageHistories\VillageHistoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditVillageHistory extends EditRecord
{
    protected static string $resource = VillageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
