<?php

namespace App\Filament\Resources\Umkms\Tables;

use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UmkmsTable
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
                    ImageColumn::make('image_path')
                        ->height('200px')
                        ->width('100%')
                        ->extraImgAttributes(['style' => 'object-fit: cover; border-radius: 0.75rem 0.75rem 0 0; width: 100%;']),
                    Stack::make([
                        TextColumn::make('name')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        TextColumn::make('category')
                            ->color('primary')
                            ->badge()
                            ->searchable(),
                    ])->space(2)->extraAttributes(['style' => 'padding: 1rem;']),
                ])
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
