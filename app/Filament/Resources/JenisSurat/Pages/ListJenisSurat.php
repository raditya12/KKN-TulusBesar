<?php

namespace App\Filament\Resources\JenisSurat\Pages;

use App\Filament\Resources\JenisSurat\JenisSuratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListJenisSurat extends ListRecords
{
    protected static string $resource = JenisSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambahkan Jenis Surat Baru'),
        ];
    }
}
