<?php

namespace App\Filament\Resources\ActivityPhotos\Pages;

use App\Filament\Resources\ActivityPhotos\ActivityPhotoResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditActivityPhoto extends EditRecord
{
    protected static string $resource = ActivityPhotoResource::class;

    protected ?string $maxWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
