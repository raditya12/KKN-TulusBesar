<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Resources\Surat\SuratResource;
use App\Models\Surat;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class ViewSurat extends ViewRecord
{
    protected static string $resource = SuratResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('lihat_dokumen')
                ->label('Lihat Dokumen')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->visible(fn (Surat $record) => ! empty($record->file_dokumen))
                ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_dokumen), shouldOpenInNewTab: true),

            Action::make('download_dokumen')
                ->label('Download Dokumen')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->visible(fn (Surat $record) => ! empty($record->file_dokumen))
                ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_dokumen), shouldOpenInNewTab: true),

            EditAction::make()
                ->label('Edit')
                ->icon('heroicon-o-pencil-square'),

            DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-o-trash')
                ->requiresConfirmation()
                ->modalHeading('Hapus Arsip Surat?')
                ->modalDescription('Arsip surat ini akan dihapus dari sistem. Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Hapus')
                ->modalCancelActionLabel('Batal')
                ->action(function (Surat $record): void {
                    if (! empty($record->file_dokumen)) {
                        Storage::disk('public')->delete($record->file_dokumen);
                    }
                    $record->delete();

                    Notification::make()
                        ->title('Arsip surat berhasil dihapus.')
                        ->success()
                        ->send();

                    $this->redirect(SuratResource::getUrl('index'));
                }),
        ];
    }
}
