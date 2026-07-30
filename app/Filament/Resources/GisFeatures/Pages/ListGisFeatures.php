<?php

namespace App\Filament\Resources\GisFeatures\Pages;

use App\Filament\Resources\GisFeatures\GisFeatureResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGisFeatures extends ListRecords
{
    protected static string $resource = GisFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
