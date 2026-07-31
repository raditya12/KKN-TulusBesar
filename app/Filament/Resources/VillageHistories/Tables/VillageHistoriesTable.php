<?php

namespace App\Filament\Resources\VillageHistories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class VillageHistoriesTable
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
                        TextColumn::make('year')
                            ->label('Tahun / Era')
                            ->badge()
                            ->color('primary')
                            ->searchable(),
                        TextColumn::make('title')
                            ->label('Judul Peristiwa')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        TextColumn::make('description')
                            ->label('Keterangan')
                            ->color('gray')
                            ->size('sm')
                            ->limit(80),
                        TextColumn::make('order_sequence')
                            ->label('Urutan')
                            ->prefix('Urutan ke-')
                            ->color('gray')
                            ->size('sm')
                            ->numeric()
                            ->sortable(),
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
