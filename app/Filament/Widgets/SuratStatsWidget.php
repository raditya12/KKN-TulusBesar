<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected array|int|null $columns = 2;

    protected function getStats(): array
    {
        $today = now()->toDateString();

        $suratHariIni = Surat::whereDate('created_at', $today)->count();
        $belumUploadScan = Surat::where('status', '!=', 'scan_uploaded')->count();

        $stats = [
            Stat::make('Surat Hari Ini', $suratHariIni)
                ->description('Dibuat hari ini')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Belum Upload Scan', $belumUploadScan)
                ->description($belumUploadScan > 0 ? 'Perlu upload berkas' : 'Semua berkas terunggah')
                ->descriptionIcon($belumUploadScan > 0 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($belumUploadScan > 0 ? 'danger' : 'success'),
        ];

        return $stats;
    }
}
