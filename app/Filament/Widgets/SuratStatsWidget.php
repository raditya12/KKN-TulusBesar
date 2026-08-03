<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = now()->toDateString();
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $suratHariIni = Surat::whereDate('created_at', $today)->count();
        $suratBulanIni = Surat::whereMonth('created_at', $currentMonth)
            ->whereYear('created_at', $currentYear)
            ->count();
        $sudahUploadScan = Surat::where('status', 'scan_uploaded')->count();
        $customSurat = Surat::where('is_custom', true)->count();
        $totalSurat = Surat::count();

        $stats = [
            Stat::make('Surat Hari Ini', $suratHariIni)
                ->description('Dibuat hari ini')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('primary'),

            Stat::make('Surat Bulan Ini', $suratBulanIni)
                ->description(now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),

            Stat::make('Total Arsip', $totalSurat)
                ->description('Semua surat')
                ->descriptionIcon('heroicon-m-archive-box')
                ->color('gray'),

            Stat::make('Sudah Scan', $sudahUploadScan)
                ->description('Surat dengan scan resmi')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Custom Surat', $customSurat)
                ->description('Surat dibuat manual')
                ->descriptionIcon('heroicon-m-pencil-square')
                ->color('warning'),
        ];

        return $stats;
    }
}
