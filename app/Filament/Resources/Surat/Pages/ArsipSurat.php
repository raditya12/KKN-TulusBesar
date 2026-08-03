<?php

namespace App\Filament\Resources\Surat\Pages;

use App\Filament\Pages\PembuatanSuratPage;
use App\Filament\Resources\Surat\SuratResource;
use App\Models\Surat;
use App\Models\SuratScan;
use Filament\Actions\Action;
use Filament\Actions\Action as TableAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ArsipSurat extends ListRecords
{
    protected static string $resource = SuratResource::class;

    protected static ?string $title = 'Arsip Surat';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('buat_surat')
                ->label('Buat Surat Baru')
                ->icon('heroicon-o-plus')
                ->url(PembuatanSuratPage::getUrl()),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Surat::query()->with(['jenisSurat', 'operator', 'scan'])->latest())
            ->columns([
                TextColumn::make('nomor_surat')
                    ->label('Nomor Surat')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('jenisSurat.nama')
                    ->label('Jenis Surat')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                TextColumn::make('nama_warga')
                    ->label('Nama Warga')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('tanggal_surat')
                    ->label('Tanggal Surat')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'dicetak' => 'info',
                        'scan_uploaded' => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => 'Draft',
                        'dicetak' => 'Sudah Dicetak',
                        'scan_uploaded' => 'Sudah Upload Scan',
                        default => $state,
                    }),

                TextColumn::make('is_custom')
                    ->label('Tipe')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Custom' : 'Template')
                    ->color(fn (bool $state): string => $state ? 'warning' : 'gray'),

                TextColumn::make('operator.name')
                    ->label('Operator')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('jenis_surat_id')
                    ->label('Jenis Surat')
                    ->relationship('jenisSurat', 'nama'),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'dicetak' => 'Sudah Dicetak',
                        'scan_uploaded' => 'Sudah Upload Scan',
                    ]),
            ])
            ->actions([
                TableAction::make('view_pdf')
                    ->label('Lihat PDF')
                    ->icon('heroicon-o-document')
                    ->color('info')
                    ->url(fn (Surat $record): string => $record->pdf_generated_path
                        ? Storage::disk('public')->url($record->pdf_generated_path)
                        : '#'
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (Surat $record): bool => (bool) $record->pdf_generated_path),

                TableAction::make('upload_scan')
                    ->label('Upload Scan')
                    ->icon('heroicon-o-arrow-up-tray')
                    ->color('success')
                    ->form([
                        FileUpload::make('file_scan')
                            ->label('File Scan (PDF/JPG)')
                            ->disk('public')
                            ->directory('scans')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(20480)
                            ->required(),

                        Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(2),
                    ])
                    ->action(function (Surat $record, array $data): void {
                        SuratScan::updateOrCreate(
                            ['surat_id' => $record->id],
                            [
                                'file_path' => $data['file_scan'],
                                'catatan' => $data['catatan'] ?? null,
                                'uploaded_by' => auth()->id(),
                            ]
                        );

                        $record->update(['status' => 'scan_uploaded']);

                        Notification::make()
                            ->title('Scan berhasil diupload')
                            ->success()
                            ->send();
                    }),

                TableAction::make('view_scan')
                    ->label('Lihat Scan')
                    ->icon('heroicon-o-photo')
                    ->color('gray')
                    ->url(fn (Surat $record): string => $record->scan
                        ? Storage::disk('public')->url($record->scan->file_path)
                        : '#'
                    )
                    ->openUrlInNewTab()
                    ->visible(fn (Surat $record): bool => (bool) $record->scan),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
