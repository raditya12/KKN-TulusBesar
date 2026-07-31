<?php

namespace App\Filament\Resources\LocationCategories\Pages;

use App\Filament\Resources\LocationCategories\LocationCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLocationCategory extends EditRecord
{
    protected static string $resource = LocationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
