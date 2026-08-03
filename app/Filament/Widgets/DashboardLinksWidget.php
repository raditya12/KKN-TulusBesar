<?php

namespace App\Filament\Widgets;


use Filament\Widgets\Widget;

class DashboardLinksWidget extends Widget
{
    protected string $view = 'filament.widgets.dashboard-links-widget';
    protected int | string | array $columnSpan = 'full';

    protected function getViewData(): array
    {
        return [
            'links' => [
                [
                    'name' => 'Berita Desa',
                    'icon' => 'heroicon-o-newspaper',
                    'url' => \App\Filament\Resources\NewsArticles\NewsArticleResource::getUrl(),
                    'description' => 'Kelola artikel dan publikasi kegiatan desa.',
                ],
                [
                    'name' => 'Data UMKM',
                    'icon' => 'heroicon-o-building-storefront',
                    'url' => \App\Filament\Resources\Umkms\UmkmResource::getUrl(),
                    'description' => 'Kelola data pelaku usaha dan produk lokal desa.',
                ],
                [
                    'name' => 'Situs Wisata & Budaya',
                    'icon' => 'heroicon-o-map',
                    'url' => \App\Filament\Resources\CulturalSites\CulturalSiteResource::getUrl(),
                    'description' => 'Kelola informasi destinasi wisata dan situs budaya.',
                ],
                [

                    'name' => 'Profil Desa',
                    'icon' => 'heroicon-o-building-library',
                    'url' => \App\Filament\Resources\VillageProfiles\VillageProfileResource::getUrl(),
                    'description' => 'Kelola data statistik, visi, misi, dan luas area.',
                ],
                [
                    'name' => 'Data WebGIS',
                    'icon' => 'heroicon-o-map-pin',
                    'url' => \App\Filament\Resources\GisFeatures\GisFeatureResource::getUrl(),
                    'description' => 'Kelola titik lokasi fasilitas umum dan pemetaan desa.',
                ],
            ]
        ];
    }
}
