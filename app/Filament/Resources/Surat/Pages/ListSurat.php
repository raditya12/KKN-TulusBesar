<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Filament\Widgets\SuratStatsWidget;
use Filament\Resources\Pages\ListRecords;

class ListSurat extends ListRecords
{
    protected static string $resource = SuratResource::class;

    public function getSubheading(): ?string
    {
        return 'Kelola dan temukan arsip surat dengan cepat';
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SuratStatsWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make()
                ->label('Tambah Arsip'),
        ];
    }
}
