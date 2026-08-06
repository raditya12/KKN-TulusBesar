<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;

class PreviewTemplateSurat extends Page
{
    use InteractsWithRecord;

    protected static string $resource = TemplateSuratResource::class;

    protected string $view = 'filament.template-surat.preview';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }

    protected function getViewData(): array
    {
        /** @var \App\Models\TemplateSurat $template */
        $template = $this->getRecord();

        return [
            'template' => $template,
            'konten' => $template->konten_html,
        ];
    }
}

