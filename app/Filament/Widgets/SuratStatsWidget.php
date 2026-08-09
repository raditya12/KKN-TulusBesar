<?php

namespace App\Filament\Widgets;

use App\Models\Surat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SuratStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Surat Hari Ini', Surat::whereDate('created_at', today())->count())
                ->description('Surat yang dibuat hari ini')
                ->icon('heroicon-o-document-text')
                ->color('info'),

            Stat::make('Surat Bulan Ini', Surat::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count())
                ->description('Surat yang dibuat bulan ini')
                ->icon('heroicon-o-calendar')
                ->color('primary'),

            Stat::make('Total Arsip', Surat::count())
                ->description('Total keseluruhan arsip surat')
                ->icon('heroicon-o-archive-box')
                ->color('success'),

            Stat::make('Surat Belum Ada Scan', Surat::where('status_scan', 'belum_upload')->count())
                ->description('Perlu diunggah berkas fisiknya')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning'),
        ];
    }
}
