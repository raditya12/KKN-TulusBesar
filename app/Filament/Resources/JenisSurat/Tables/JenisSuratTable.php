<?php

namespace App\Filament\Resources\JenisSurat\Tables;

use App\Models\JenisSurat;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class JenisSuratTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Jenis Surat')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('kode')
                    ->label('Kode')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('template_surat_count')
                    ->label('Template')
                    ->counts('templateSurat')
                    ->badge()
                    ->color('info'),

                IconColumn::make('is_system')
                    ->label('Bawaan Sistem')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-user')
                    ->trueColor('warning')
                    ->falseColor('gray'),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')->label('Status Aktif'),
                TernaryFilter::make('is_system')->label('Bawaan Sistem'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()
                    ->hidden(fn (JenisSurat $record) => $record->is_system)
                    ->requiresConfirmation(),
            ])
            ->defaultSort('nama');
    }
}
