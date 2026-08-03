<?php

namespace App\Filament\Resources\JenisSurat\Pages;

use App\Filament\Resources\JenisSurat\JenisSuratResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditJenisSurat extends EditRecord
{
    protected static string $resource = JenisSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->hidden(fn () => $this->record->is_system),
        ];
    }
}
