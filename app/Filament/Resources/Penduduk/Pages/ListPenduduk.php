<?php

namespace App\Filament\Resources\Penduduk\Pages;

use App\Filament\Resources\Penduduk\PendudukResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;

class ListPenduduk extends ListRecords
{
    protected static string $resource = PendudukResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Data Warga';
    }

    public function getSubheading(): ?string
    {
        return 'Daftar seluruh penduduk Desa Tulusbesar.';
    }
}
