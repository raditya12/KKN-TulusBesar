<?php

namespace App\Filament\Resources\MasterPlaceholders\Tables;

use App\Models\MasterPlaceholder;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MasterPlaceholderTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kategori')
                    ->label('Kategori')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('nama_field')
                    ->label('Nama Field')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('placeholder')
                    ->label('Placeholder')
                    ->badge()
                    ->color('success')
                    ->copyable()
                    ->copyMessage('Placeholder disalin!')
                    ->fontFamily('mono'),

                TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(60)
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('kategori')
                    ->label('Kategori')
                    ->options(fn () => MasterPlaceholder::query()
                        ->distinct()
                        ->pluck('kategori', 'kategori')
                        ->toArray()
                    ),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
            ])
            ->defaultSort('kategori');
    }
}
