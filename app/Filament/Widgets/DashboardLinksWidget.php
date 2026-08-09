<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\PembuatanSuratPage;
use App\Filament\Resources\JenisSurat\JenisSuratResource;
use App\Filament\Resources\Surat\SuratResource;
use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use Filament\Widgets\Widget;

class DashboardLinksWidget extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.dashboard-links-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'links' => [
                [
                    'name' => 'Jenis Surat',
                    'icon' => 'heroicon-o-document-text',
                    'url'  => JenisSuratResource::getUrl(),
                ],
                [
                    'name' => 'Template Surat',
                    'icon' => 'heroicon-o-document-duplicate',
                    'url'  => TemplateSuratResource::getUrl(),
                ],
                [
                    'name' => 'Pembuatan Surat',
                    'icon' => 'heroicon-o-pencil-square',
                    'url'  => PembuatanSuratPage::getUrl(),
                ],
                [
                    'name' => 'Arsip Surat',
                    'icon' => 'heroicon-o-archive-box',
                    'url'  => SuratResource::getUrl(),
                ],
            ],
        ];
    }
}
