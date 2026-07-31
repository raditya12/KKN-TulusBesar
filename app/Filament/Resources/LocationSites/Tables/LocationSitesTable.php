<?php

namespace App\Filament\Resources\LocationSites\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LocationSitesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('Gambar')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Lokasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('locationCategory.name')
                    ->label('Kategori')
                    ->searchable()
                    ->badge()
                    ->color(fn ($record) => match ($record->locationCategory?->name) {
                        'Situs Budaya' => 'primary',
                        'Fasilitas Umum' => 'tertiary',
                        'Peternakan' => 'secondary',
                        'PJU' => 'warning',
                        'Sampah' => 'success',
                        'UMKM' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('qr_code')
                    ->label('Kode QR')
                    ->searchable()
                    ->html()
                    ->formatStateUsing(function ($state, $record) {
                        if (!$state) return '-';
                        $options = new \chillerlan\QRCode\QROptions([
                            'outputType' => \chillerlan\QRCode\Output\QROutputInterface::GDIMAGE_PNG,
                            'scale' => 5,
                            'imageBase64' => true,
                        ]);
                        $dataUri = (new \chillerlan\QRCode\QRCode($options))->render($record->short_url);
                        return '<div class="flex flex-col items-center gap-2 py-2">
                                    <img src="'.$dataUri.'" alt="QR Code" style="width: 80px; height: 80px; object-fit: contain;" class="rounded-md border bg-white p-1 shadow-sm" />
                                    <a href="'.$record->short_url.'" target="_blank" class="text-primary-600 hover:text-primary-500 hover:underline text-xs text-center">Uji Coba Link</a>
                                </div>';
                    })
                    ->copyable()
                    ->copyableState(fn ($record) => $record->short_url)
                    ->copyMessage('Link disalin!')
                    ->toggleable(),
                TextColumn::make('qr_visits')
                    ->label('Kunjungan QR')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color('info')
                    ->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                \Filament\Actions\Action::make('download_qr')
                    ->label('Download QR')
                    ->icon('heroicon-o-qr-code')
                    ->color('success')
                    ->visible(fn ($record) => !empty($record->qr_code))
                    ->action(function ($record) {
                        $options = new \chillerlan\QRCode\QROptions([
                            'outputType' => \chillerlan\QRCode\Output\QROutputInterface::GDIMAGE_PNG,
                            'scale' => 20, // High res for printing
                            'imageBase64' => false,
                        ]);
                        $qr = (new \chillerlan\QRCode\QRCode($options))->render($record->short_url);

                        return response()->streamDownload(function () use ($qr) {
                            echo $qr;
                        }, $record->slug.'-qr.png', [
                            'Content-Type' => 'image/png',
                        ]);
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
