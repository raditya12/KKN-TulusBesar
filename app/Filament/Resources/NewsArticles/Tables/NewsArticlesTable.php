<?php

namespace App\Filament\Resources\NewsArticles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
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
                        ->disk('public')
                        ->height(200)
                        ->width('100%')
                        ->defaultImageUrl(asset('images/dummy/hero.jpg'))
                        ->extraAttributes(['class' => 'rounded-t-xl overflow-hidden'])
                        ->extraImgAttributes(['class' => 'w-full h-[200px] object-cover rounded-t-xl']),
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
