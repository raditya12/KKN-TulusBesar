<?php

namespace App\Filament\Resources\MasterPlaceholders\Pages;

use App\Filament\Resources\MasterPlaceholders\MasterPlaceholderResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMasterPlaceholders extends ListRecords
{
    protected static string $resource = MasterPlaceholderResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
