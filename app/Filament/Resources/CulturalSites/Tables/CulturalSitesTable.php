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
                        TextColumn::make('category')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'sejarah' => 'primary',
                                'budaya' => 'warning',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'sejarah' => 'Sejarah & Religi',
                                'budaya' => 'Seni & Tradisi',
                                default => $state,
                            }),
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
                \Filament\Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options(function () {
                        $defaults = [
                            'sejarah' => 'Sejarah & Religi',
                            'budaya'  => 'Seni & Tradisi',
                        ];
                        $existing = \App\Models\CulturalSite::query()
                            ->whereNotNull('category')
                            ->distinct()
                            ->pluck('category', 'category')
                            ->toArray();
                        
                        unset($existing['sejarah'], $existing['budaya']);
                        
                        return $defaults + $existing;
                    }),
            ])
            ->recordActions([
                EditAction::make()->button(),
                DeleteAction::make()->button(),
                Action::make('qr_code')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->button()
                    ->modalHeading('QR Code Situs Wisata')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn ($record) => view('filament.components.qr-code', [
                        'url' => route('wisata.show', $record->slug),
                        'title' => $record->name,
                    ])),
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
