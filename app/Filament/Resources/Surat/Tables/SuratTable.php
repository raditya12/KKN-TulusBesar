<?php

namespace App\Filament\Resources\Surat\Tables;

use App\Models\JenisSurat;
use App\Models\Surat;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
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

                TextColumn::make('nama_pemohon')
                    ->label('Nama Pemohon')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('jenisSurat.nama_surat')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('primary')
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('created_at')
                    ->label('Tanggal Arsip')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->size('sm'),

                TextColumn::make('file_dokumen')
                    ->label('Dokumen')
                    ->formatStateUsing(function ($state) {
                        if (! $state) {
                            return '-';
                        }
                        $ext = strtoupper(pathinfo($state, PATHINFO_EXTENSION));

                        return $ext ?: 'FILE';
                    })
                    ->badge()
                    ->color(fn ($state) => match (strtolower(pathinfo($state ?? '', PATHINFO_EXTENSION))) {
                        'pdf' => 'danger',
                        'docx', 'doc' => 'info',
                        default => 'gray',
                    }),
            ])

            // ── Search ───────────────────────────────────────────────
            ->searchPlaceholder('Cari nomor surat atau nama pemohon...')

            // ── Filters ──────────────────────────────────────────────
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->options(fn () => JenisSurat::active()->pluck('nama_surat', 'id')->toArray())
                    ->placeholder('Semua Jenis'),

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
                ViewAction::make()
                    ->label('Detail'),

                ActionGroup::make([
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
                        ->color('danger')
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
            ->emptyStateDescription('Klik tombol "Tambah Arsip Surat" untuk mulai mengarsipkan dokumen surat.')

            // ── Visual ────────────────────────────────────────────────
            ->striped()
            ->defaultSort('created_at', 'desc');
    }
}
