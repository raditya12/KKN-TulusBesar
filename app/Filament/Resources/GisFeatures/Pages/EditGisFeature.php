<?php

namespace App\Filament\Resources\GisFeatures\Pages;

use App\Filament\Resources\GisFeatures\GisFeatureResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGisFeature extends EditRecord
{
    protected static string $resource = GisFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
