<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class DashboardHeroWidget extends Widget
{
    protected static ?int $sort = 0;
    protected string $view = 'filament.widgets.dashboard-hero-widget';
    protected int|string|array $columnSpan = 'full';
    protected static bool $isLazy = false;

    protected function getViewData(): array
    {
        $hour = now()->hour;

        $salam = match (true) {
            $hour >= 0 && $hour < 11  => 'Selamat Pagi',
            $hour >= 11 && $hour < 15 => 'Selamat Siang',
            $hour >= 15 && $hour < 18 => 'Selamat Sore',
            default                   => 'Selamat Malam',
        };

        $icon = match (true) {
            $hour >= 0 && $hour < 11  => '☀️',
            $hour >= 11 && $hour < 15 => '🌤️',
            $hour >= 15 && $hour < 18 => '🌅',
            default                   => '🌙',
        };

        return [
            'salam' => $salam,
            'icon'  => $icon,
            'waktu' => now()->format('H:i'),
            'tanggal' => now()->translatedFormat('l, d F Y'),
        ];
    }
}
