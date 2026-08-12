<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getStats(): array
    {
        $total = Surat::count();
        $bulanIni = Surat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $namaBulan = now()->translatedFormat('F Y');

        return [
            Stat::make('Total Surat', $total)
                ->description('Seluruh arsip surat')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make('Diarsipkan Bulan Ini', $bulanIni)
                ->description('Arsip surat bulan '.$namaBulan)
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('success'),
        ];
    }
}
