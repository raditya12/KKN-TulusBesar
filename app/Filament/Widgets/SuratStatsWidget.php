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
        $total    = Surat::count();
        $bulanIni = Surat::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $hariIni  = Surat::whereDate('created_at', today())->count();

        $namaBulan = now()->translatedFormat('F Y');

        return [
            Stat::make('Total Surat', $total)
                ->description('Seluruh arsip surat')
                ->descriptionIcon('heroicon-o-archive-box')
                ->color('primary'),

            Stat::make('Surat Bulan Ini', $bulanIni)
                ->description('Arsip surat bulan ' . $namaBulan)
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('success'),

            Stat::make('Surat Hari Ini', $hariIni)
                ->description('Arsip surat dibuat hari ini')
                ->descriptionIcon('heroicon-o-clock')
                ->color('info'),
        ];
    }
}
