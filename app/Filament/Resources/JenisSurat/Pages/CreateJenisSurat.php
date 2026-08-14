<?php

namespace App\Filament\Resources\JenisSurat\Pages;

use App\Filament\Resources\JenisSurat\JenisSuratResource;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisSurat extends CreateRecord
{
    protected static string $resource = JenisSuratResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
