<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\LocationSites\LocationSiteResource;
use App\Filament\Resources\NewsArticles\NewsArticleResource;
use App\Filament\Resources\Umkms\UmkmResource;
use App\Filament\Resources\VillageHistories\VillageHistoryResource;
use App\Filament\Resources\VillageProfiles\VillageProfileResource;
use Filament\Widgets\Widget;

class DashboardLinksWidget extends Widget
{
    protected string $view = 'filament.widgets.dashboard-links-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'links' => [
                [
                    'name' => 'Berita Desa',
                    'icon' => 'heroicon-o-newspaper',
                    'url' => NewsArticleResource::getUrl(),
                    'description' => 'Kelola artikel dan publikasi kegiatan desa.',
                ],
                [
                    'name' => 'Data UMKM',
                    'icon' => 'heroicon-o-building-storefront',
                    'url' => UmkmResource::getUrl(),
                    'description' => 'Kelola data pelaku usaha dan produk lokal desa.',
                ],
                [
                    'name' => 'Situs Lokasi',
                    'icon' => 'heroicon-o-map-pin',
                    'url' => LocationSiteResource::getUrl(),
                    'description' => 'Kelola titik lokasi fasilitas umum, peternakan, situs budaya dan pemetaan desa.',
                ],
                [
                    'name' => 'Garis Waktu Sejarah',
                    'icon' => 'heroicon-o-clock',
                    'url' => VillageHistoryResource::getUrl(),
                    'description' => 'Kelola rentetan sejarah desa Tulusbesar.',
                ],
                [
                    'name' => 'Profil Desa',
                    'icon' => 'heroicon-o-building-library',
                    'url' => VillageProfileResource::getUrl(),
                    'description' => 'Kelola data statistik, visi, misi, dan luas area.',
                ],
            ],
        ];
    }
}
