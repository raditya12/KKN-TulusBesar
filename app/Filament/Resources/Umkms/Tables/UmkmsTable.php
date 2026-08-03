<?php

namespace App\Filament\Resources\Umkms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Stack;
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
                        ->disk('public')
                        ->height(200)
                        ->width('100%')
                        ->defaultImageUrl(asset('images/dummy/umkm1.jpg'))
                        ->extraAttributes(['class' => 'rounded-t-xl overflow-hidden'])
                        ->extraImgAttributes(['class' => 'w-full h-[200px] object-cover rounded-t-xl']),
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
                ]),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()->button(),
                DeleteAction::make()->button(),
                \Filament\Actions\Action::make('qr_code')
                    ->label('QR Code')
                    ->icon('heroicon-o-qr-code')
                    ->color('info')
                    ->button()
                    ->modalHeading('QR Code UMKM')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalContent(fn ($record) => view('filament.components.qr-code', [
                        'url' => route('umkm.show', $record->slug),
                        'title' => $record->name,
                    ])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
