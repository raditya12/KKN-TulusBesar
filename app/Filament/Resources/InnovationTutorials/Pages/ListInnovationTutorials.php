<?php

namespace App\Filament\Resources\InnovationTutorials\Pages;

use App\Filament\Resources\InnovationTutorials\InnovationTutorialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInnovationTutorials extends ListRecords
{
    protected static string $resource = InnovationTutorialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
