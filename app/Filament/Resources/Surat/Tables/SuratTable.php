<?php

namespace App\Filament\Resources\Surat\Tables;

use App\Models\JenisSurat;
use App\Models\Surat;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
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

                TextColumn::make('status_scan')
                    ->label('Status Scan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'sudah_upload' => 'success',
                        default        => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'sudah_upload' => 'Sudah Upload',
                        default        => 'Belum Upload',
                    })
                    ->sortable(),
            ])

            // ── Search ───────────────────────────────────────────────
            ->searchPlaceholder('Cari nama pemohon atau nomor surat...')

            // ── Filters ──────────────────────────────────────────────
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->options(fn () => JenisSurat::pluck('nama_surat', 'id')->toArray()),

                SelectFilter::make('status_scan')
                    ->label('Status Scan')
                    ->options([
                        'belum_upload' => 'Belum Upload',
                        'sudah_upload' => 'Sudah Upload',
                    ]),

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

                    Action::make('upload_scan')
                        ->label('Upload Scan')
                        ->icon('heroicon-o-arrow-up-tray')
                        ->color('success')
                        ->modalHeading('Upload Berkas Hasil Scan Surat')
                        ->modalDescription('Upload file hasil scan fisik surat yang telah ditandatangani dan distempel (Format: PDF, JPG, PNG).')
                        ->form([
                            FileUpload::make('file_scan')
                                ->label('File Scan (PDF / JPG / PNG)')
                                ->directory('arsip-surat/scan')
                                ->disk('public')
                                ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                                ->maxSize(15360) // 15MB
                                ->required(),
                        ])
                        ->action(function (Surat $record, array $data): void {
                            $record->update([
                                'file_scan'   => $data['file_scan'],
                                'status_scan' => 'sudah_upload',
                            ]);

                            Notification::make()
                                ->title('Hasil Scan Berhasil Diupload')
                                ->body('Status arsip surat berhasil diperbarui menjadi Sudah Upload.')
                                ->success()
                                ->send();
                        }),

                    Action::make('download_scan')
                        ->label('Lihat Scan')
                        ->icon('heroicon-o-paper-clip')
                        ->color('gray')
                        ->visible(fn (Surat $record) => ! empty($record->file_scan))
                        ->url(fn (Surat $record) => Storage::disk('public')->url($record->file_scan), shouldOpenInNewTab: true),
                ])
                ->label('Akses')
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
