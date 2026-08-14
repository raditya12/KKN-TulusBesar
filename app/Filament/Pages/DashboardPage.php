<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardHeroWidget;
use App\Filament\Widgets\DashboardMainWidget;
use App\Filament\Widgets\DashboardStatsWidget;
use App\Filament\Widgets\PanduanSistemWidget;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class DashboardPage extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    public function getTitle(): string|Htmlable
    {
        return 'Dashboard';
    }

    public function getSubheading(): ?string
    {
        return 'Kelola dan pantau arsip surat Desa Tulusbesar.';
    }

    public function getWidgets(): array
    {
        return [
            DashboardHeroWidget::class,
            DashboardStatsWidget::class,
            DashboardMainWidget::class,
            PanduanSistemWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
