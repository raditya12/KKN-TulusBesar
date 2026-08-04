<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\PembuatanSuratPage;
use App\Filament\Resources\JenisSurat\JenisSuratResource;
use App\Filament\Resources\MasterPlaceholders\MasterPlaceholderResource;
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
                    'name' => 'Buat Surat',
                    'icon' => 'heroicon-o-plus',
                    'url' => PembuatanSuratPage::getUrl(),
                    'description' => 'Mulai membuat surat baru secara dinamis.',
                ],
                [
                    'name' => 'Arsip Surat',
                    'icon' => 'heroicon-o-archive-box',
                    'url' => SuratResource::getUrl(),
                    'description' => 'Lihat dan kelola berkas arsip surat desa.',
                ],
                [
                    'name' => 'Template Surat',
                    'icon' => 'heroicon-o-document-duplicate',
                    'url' => TemplateSuratResource::getUrl(),
                    'description' => 'Kelola template format surat resmi.',
                ],
                [
                    'name' => 'Jenis Surat',
                    'icon' => 'heroicon-o-document-text',
                    'url' => JenisSuratResource::getUrl(),
                    'description' => 'Kelola klasifikasi dan jenis surat.',
                ],
                [
                    'name' => 'Master Placeholder',
                    'icon' => 'heroicon-o-code-bracket',
                    'url' => MasterPlaceholderResource::getUrl(),
                    'description' => 'Kelola placeholder variabel template.',
                ],
            ],
        ];
    }
}
