<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\Surat\SuratResource;
use App\Models\Surat;
use Filament\Widgets\Widget;

class DashboardMainWidget extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.dashboard-main-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $arsipTerbaru = Surat::orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $arsipUrl = SuratResource::getUrl();

        return compact('arsipTerbaru', 'arsipUrl');
    }
}
