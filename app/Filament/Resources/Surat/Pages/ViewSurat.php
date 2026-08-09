<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Models\Surat;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewSurat extends ViewRecord
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('download_docx')
                ->label('Unduh DOCX')
                ->icon('heroicon-o-document-text')
                ->color('info')
                ->visible(fn (Surat $record) => ! empty($record->file_docx))
                ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_docx), shouldOpenInNewTab: true),

            Action::make('download_pdf')
                ->label('Unduh PDF')
                ->icon('heroicon-o-document')
                ->color('danger')
                ->visible(fn (Surat $record) => ! empty($record->file_pdf))
                ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_pdf), shouldOpenInNewTab: true),

            Action::make('download_scan')
                ->label('Lihat Hasil Scan')
                ->icon('heroicon-o-paper-clip')
                ->color('success')
                ->visible(fn (Surat $record) => ! empty($record->file_scan))
                ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_scan), shouldOpenInNewTab: true),
        ];
    }
}
