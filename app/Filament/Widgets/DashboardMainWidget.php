<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\PembuatanSuratPage;
use App\Filament\Resources\JenisSurat\JenisSuratResource;
use App\Filament\Resources\Surat\SuratResource;
use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Models\Surat;
use Filament\Widgets\Widget;

class DashboardMainWidget extends Widget
{
    protected static ?int $sort = 2;

    protected string $view = 'filament.widgets.dashboard-main-widget';

    protected int|string|array $columnSpan = 'full';

    protected function getViewData(): array
    {
        $totalSurat       = Surat::count();
        $sudahUpload      = Surat::where('status_scan', 'sudah_upload')->count();
        $belumUploadCount = $totalSurat - $sudahUpload;

        $perluTindakan = Surat::with('jenisSurat')
            ->where('status_scan', 'belum_upload')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();


        $links = [
            [
                'name' => 'Buat Surat',
                'icon' => 'heroicon-o-plus-circle',
                'url'  => PembuatanSuratPage::getUrl(),
                'primary' => false,
            ],
            [
                'name' => 'Arsip Surat',
                'icon' => 'heroicon-o-archive-box',
                'url'  => SuratResource::getUrl(),
                'primary' => false,
            ],
            [
                'name' => 'Template Surat',
                'icon' => 'heroicon-o-document-duplicate',
                'url'  => TemplateSuratResource::getUrl(),
                'primary' => false,
            ],
            [
                'name' => 'Jenis Surat',
                'icon' => 'heroicon-o-document-text',
                'url'  => JenisSuratResource::getUrl(),
                'primary' => false,
            ],
        ];

        return compact(
            'totalSurat',
            'sudahUpload',
            'belumUploadCount',
            'perluTindakan',
            'links'
        );
    }
}
