<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Services\DocxService;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditTemplateSurat extends EditRecord
{
    protected static string $resource = TemplateSuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $this->validateNoPlaceholderIssues();
    }

    private function validateNoPlaceholderIssues(): void
    {
        $state = $this->data['file_docx'] ?? null;
        if (is_array($state)) {
            $state = array_key_first($state) ?: (array_values($state)[0] ?? null);
        }

        if (! $state) {
            return;
        }

        $docxPath = Storage::disk('public')->path($state);
        if (! file_exists($docxPath)) {
            $docxPath = Storage::disk('local')->path($state);
        }

        if (! $docxPath || ! file_exists($docxPath)) {
            return;
        }

        /** @var DocxService $docxService */
        $docxService = app(DocxService::class);
        $analysis    = $docxService->analyzePlaceholders($docxPath);

        if (! empty($analysis['duplicates'])) {
            $dupList = collect($analysis['duplicates'])
                ->map(fn ($count, $key) => "[{$key}] ditemukan {$count} kali")
                ->implode(', ');

            Notification::make()
                ->danger()
                ->title('Template belum dapat disimpan')
                ->body("Ada data yang menggunakan nama placeholder yang sama: {$dupList}. Silakan perbaiki file Word terlebih dahulu.")
                ->persistent()
                ->send();

            $this->halt();
        }

        if (! empty($analysis['malformed'])) {
            $malformedList = implode(', ', $analysis['malformed']);

            Notification::make()
                ->warning()
                ->title('Peringatan: Ada data yang tidak terbaca')
                ->body("Kemungkinan typo pada bracket: {$malformedList}. Pastikan setiap placeholder menggunakan format [NamaData] dengan benar.")
                ->persistent()
                ->send();

            // Malformed tidak memblokir simpan — hanya warning
        }
    }
}
