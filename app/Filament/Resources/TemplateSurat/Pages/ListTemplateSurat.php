<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTemplateSurat extends ListRecords
{
    protected static string $resource = TemplateSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Upload Template')];
    }
}
