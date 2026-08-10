<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Filament\Widgets\SuratStatsWidget;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

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

    public function getTabs(): array
    {
        return [
            'semua' => Tab::make('Semua Surat')
                ->icon('heroicon-o-archive-box'),

            'belum_upload' => Tab::make('Belum Upload')
                ->icon('heroicon-o-exclamation-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_scan', 'belum_upload')),

            'sudah_upload' => Tab::make('Sudah Upload')
                ->icon('heroicon-o-check-circle')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_scan', 'sudah_upload')),
        ];
    }
}
