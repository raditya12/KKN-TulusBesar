<?php

namespace App\Filament\Resources\NewsArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NewsArticlesTable
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
                        TextColumn::make('title')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        TextColumn::make('published_at')
                            ->dateTime()
                            ->color('gray')
                            ->icon('heroicon-o-calendar')
                            ->size('sm'),
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
