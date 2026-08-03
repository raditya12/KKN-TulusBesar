<?php

namespace App\Filament\Resources\MasterPlaceholders\Pages;

use App\Filament\Resources\MasterPlaceholders\MasterPlaceholderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMasterPlaceholder extends EditRecord
{
    protected static string $resource = MasterPlaceholderResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
