<?php

namespace App\Filament\Resources\VillageHistories\Pages;

use App\Filament\Resources\VillageHistories\VillageHistoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVillageHistories extends ListRecords
{
    protected static string $resource = VillageHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
