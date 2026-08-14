<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateSurat extends CreateRecord
{
    protected static string $resource = SuratResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Tambah Arsip Surat';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return null;
    }

    protected function afterCreate(): void
    {
        Notification::make()
            ->title('Arsip surat berhasil disimpan.')
            ->success()
            ->send();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }
}
