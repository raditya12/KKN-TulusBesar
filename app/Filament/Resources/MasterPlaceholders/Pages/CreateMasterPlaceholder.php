<?php

namespace App\Filament\Resources\MasterPlaceholders\Pages;

use App\Filament\Resources\MasterPlaceholders\MasterPlaceholderResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMasterPlaceholder extends CreateRecord
{
    protected static string $resource = MasterPlaceholderResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
