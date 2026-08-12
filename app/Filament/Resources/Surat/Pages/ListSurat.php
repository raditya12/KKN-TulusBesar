<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSurat extends ListRecords
{
    protected static string $resource = SuratResource::class;

    public function getSubheading(): ?string
    {
        return 'Kelola dan cari dokumen arsip surat Desa Tulusbesar.';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Arsip Surat')
                ->icon('heroicon-o-plus-circle'),
        ];
    }
}
