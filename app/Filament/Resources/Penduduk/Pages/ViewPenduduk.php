<?php

namespace App\Filament\Resources\Penduduk\Pages;

use App\Filament\Resources\Penduduk\PendudukResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class ViewPenduduk extends ViewRecord
{
    protected static string $resource = PendudukResource::class;

    public function getTitle(): string|Htmlable
    {
        return $this->record->nama ?? 'Detail Warga';
    }
}
