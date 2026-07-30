<?php

namespace App\Filament\Resources\GisFeatures\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GisFeaturesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    Stack::make([
                        TextColumn::make('category')
                            ->label('Kategori')
                            ->badge()
                            ->color('primary'),
                        TextColumn::make('name')
                            ->label('Nama Lokasi')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        TextColumn::make('latitude')
                            ->label('Koordinat')
                            ->formatStateUsing(fn ($record) => "📍 {$record->latitude}, {$record->longitude}")
                            ->color('gray')
                            ->size('sm'),
                    ])->space(2)->extraAttributes(['style' => 'padding: 1.25rem;']),
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->button(),
                DeleteAction::make()->button(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
