<?php

namespace App\Filament\Resources\Surat\Tables;

use App\Models\JenisSurat;
use App\Models\Surat;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class SuratTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // ── Columns ──────────────────────────────────────────────
            ->columns([
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('Nomor surat disalin')
                    ->weight('semibold')
                    ->fontFamily('mono')
                    ->size('sm'),

                TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_pemohon')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->size('sm'),
            ])

            // ── Search ───────────────────────────────────────────────
            ->searchPlaceholder('Cari nama pemohon atau nomor surat...')

            // ── Filters ──────────────────────────────────────────────
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->options(fn () => JenisSurat::pluck('nama_surat', 'id')->toArray()),

                Filter::make('created_at')
                    ->label('Rentang Tanggal')
                    ->schema([
                        DatePicker::make('created_from')->label('Dari Tanggal'),
                        DatePicker::make('created_until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])

            // ── Record Actions ────────────────────────────────────────
            ->recordActions([
                // Tombol utama: Detail (paling penting)
                ViewAction::make()
                    ->label('Detail'),

                // Dropdown semua aksi sekunder
                ActionGroup::make([
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

                    DeleteAction::make()
                        ->label('Hapus')
                        ->icon('heroicon-o-trash')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Arsip Surat')
                        ->modalDescription('Tindakan ini akan menghapus arsip surat beserta semua file-nya secara permanen dan tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->action(function (Surat $record): void {
                            // Hapus file-file terkait dari storage
                            foreach (['file_docx', 'file_pdf', 'file_dokumen'] as $field) {
                                if (! empty($record->$field)) {
                                    Storage::disk('public')->delete($record->$field);
                                }
                            }

                            $record->delete();

                            Notification::make()
                                ->title('Arsip Surat Dihapus')
                                ->body('Surat berhasil dihapus beserta seluruh file-nya.')
                                ->success()
                                ->send();
                        }),
                ])
                ->label('Aksi')
                ->button()
                ->color('gray')
                ->size('sm'),
            ])

            // ── Toolbar ───────────────────────────────────────────────
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            // ── Empty State ───────────────────────────────────────────
            ->emptyStateIcon('heroicon-o-archive-box')
            ->emptyStateHeading('Belum ada arsip surat')
            ->emptyStateDescription('Arsip surat yang dibuat melalui pembuatan surat akan muncul di sini.')

            // ── Visual ────────────────────────────────────────────────
            ->striped()
            ->defaultSort('created_at', 'desc');
    }
}
