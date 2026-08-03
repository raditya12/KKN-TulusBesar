<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Models\TemplateSurat as TemplateSuratModel;
use Filament\Resources\Pages\Page;

class PreviewTemplateSurat extends Page
{
    protected static string $resource = TemplateSuratResource::class;

    protected string $view = 'filament.template-surat.preview';

    public TemplateSuratModel $record;

    public function mount(int|string $record): void
    {
        $this->record = TemplateSuratModel::findOrFail($record);
    }

    protected function getViewData(): array
    {
        return [
            'template' => $this->record,
            'konten' => $this->record->konten_html,
        ];
    }
}
