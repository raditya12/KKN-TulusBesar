<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Storage;

class EditSurat extends EditRecord
{
    protected static string $resource = SuratResource::class;

    public function getTitle(): string|Htmlable
    {
        return 'Edit Arsip Surat';
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return null;
    }

    protected function afterSave(): void
    {
        // Hapus file lama jika user mengupload file baru
        $originalFile = $this->record->getOriginal('file_dokumen');
        $newFile = $this->record->file_dokumen;

        if ($originalFile && $newFile && $originalFile !== $newFile) {
            Storage::disk('public')->delete($originalFile);
        }

        Notification::make()
            ->title('Arsip surat berhasil diperbarui.')
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

    protected function getHeaderActions(): array
    {
        return [
            Action::make('batal')
                ->label('Batal')
                ->color('gray')
                ->url($this->getResource()::getUrl('index')),
        ];
    }
}
