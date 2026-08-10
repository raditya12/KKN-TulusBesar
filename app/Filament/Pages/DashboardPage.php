<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardHeroWidget;
use App\Filament\Widgets\DashboardMainWidget;
use App\Filament\Widgets\DashboardStatsWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class DashboardPage extends BaseDashboard
{
    protected static ?string $navigationLabel = 'Dashboard';

    // Sembunyikan judul default — hero widget sudah berisi heading
    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    public function getWidgets(): array
    {
        return [
            DashboardHeroWidget::class,
            DashboardStatsWidget::class,
            DashboardMainWidget::class,
        ];
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
