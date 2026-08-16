<?php

namespace App\Filament\Resources\JenisSurat\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JenisSuratTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_surat')
                    ->label('Nama Surat')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),

                TextColumn::make('kode_surat')
                    ->label('Kode Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(80)
                    ->placeholder('—')
                    ->wrap(),

                TextColumn::make('surats_count')
                    ->label('Total Surat')
                    ->counts('surats')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'gray')
                    ->suffix(fn (int $state): string => $state === 1 ? ' surat' : ' surat')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateHeading('Belum ada jenis surat')
            ->emptyStateDescription('Tambahkan jenis surat untuk mengelompokkan arsip.')
            ->defaultSort('nama_surat');
    }
}
