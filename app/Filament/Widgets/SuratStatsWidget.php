<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatsWidget extends StatsOverviewWidget
{
    // Widget hanya ditampilkan di halaman Arsip Surat (via getHeaderWidgets di ListSurat)
    protected static bool $isLazy = false;

    protected function getStats(): array
    {
        $total        = Surat::count();
        $sudahUpload  = Surat::where('status_scan', 'sudah_upload')->count();
        $belumUpload  = Surat::where('status_scan', 'belum_upload')->count();

        return [
            Stat::make('Total Surat', $total)
                ->description('Seluruh arsip surat')
                ->color('gray'),

            Stat::make('Sudah Upload Scan', $sudahUpload)
                ->description('Surat yang sudah di-scan')
                ->color('success'),

            Stat::make('Belum Upload Scan', $belumUpload)
                ->description('Surat yang perlu di-scan')
                ->color('warning'),
        ];
    }
}
