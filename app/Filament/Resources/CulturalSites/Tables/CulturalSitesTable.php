<?php

namespace App\Filament\Resources\CulturalSites\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CulturalSitesTable
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
                        ->defaultImageUrl(asset('images/dummy/wisata1.jpg'))
                        ->extraAttributes(['class' => 'rounded-t-xl overflow-hidden'])
                        ->extraImgAttributes(['class' => 'w-full h-[200px] object-cover rounded-t-xl']),
                    Stack::make([
                        TextColumn::make('name')
                            ->weight('bold')
                            ->size('lg')
                            ->searchable(),
                        TextColumn::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'active' => 'success',
                                'inactive' => 'danger',
                                default => 'gray',
                            }),
                    ])->space(2)->extraAttributes(['style' => 'padding: 1rem;']),
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->button(),
                DeleteAction::make()->button(),
                Action::make('active')
                    ->label('Aktif')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->button()
                    ->action(fn ($record) => $record->update(['status' => 'active']))
                    ->visible(fn ($record) => $record->status !== 'active'),
                Action::make('inactive')
                    ->label('Nonaktif')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->button()
                    ->action(fn ($record) => $record->update(['status' => 'inactive']))
                    ->visible(fn ($record) => $record->status === 'active'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
