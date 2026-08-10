<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    
    // Default column span in Dashboard is handled by Dashboard::getColumns()
    // but we can set columns for the stats overview itself
    protected function getColumns(): int
    {
        return 4;
    }

    protected function getStats(): array
    {
        $total       = Surat::count();
        $sudahUpload = Surat::where('status_scan', 'sudah_upload')->count();
        $belumUpload = Surat::where('status_scan', 'belum_upload')->count();
        $bulanIni    = Surat::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        return [
            Stat::make('Total Arsip', $total)
                ->description('Seluruh arsip surat')
                ->color('gray'),

            Stat::make('Sudah Upload Scan', $sudahUpload)
                ->description('Arsip digital tersedia')
                ->color('success'),

            Stat::make('Belum Upload Scan', $belumUpload)
                ->description('Surat yang perlu di-scan')
                ->color($belumUpload > 0 ? 'warning' : 'success'),

            Stat::make('Surat Bulan Ini', $bulanIni)
                ->description('Surat dibuat bulan ini')
                ->color('primary'),
        ];
    }
}
