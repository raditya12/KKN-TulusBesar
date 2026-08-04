<?php

namespace App\Filament\Resources\ActivityPhotos\Pages;

use App\Filament\Resources\ActivityPhotos\ActivityPhotoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListActivityPhotos extends ListRecords
{
    protected static string $resource = ActivityPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
