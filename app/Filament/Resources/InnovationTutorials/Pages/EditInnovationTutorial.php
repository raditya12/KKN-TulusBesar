<?php

namespace App\Filament\Resources\InnovationTutorials\Pages;

use App\Filament\Resources\InnovationTutorials\InnovationTutorialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInnovationTutorial extends EditRecord
{
    protected static string $resource = InnovationTutorialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
