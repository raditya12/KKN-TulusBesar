<?php

namespace App\Filament\Resources\VillageHistories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class VillageHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Momen Sejarah')
                        ->description('Judul dan cerita peristiwa sejarah.')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Peristiwa')
                                ->helperText('Contoh: Pelarian Senopati.')
                                ->required(),
                            Textarea::make('description')
                                ->label('Keterangan')
                                ->helperText('Ceritakan peristiwa yang terjadi pada era tersebut.')
                                ->columnSpanFull(),
                        ])->columnSpan(2),
                        
                    Section::make('Pengaturan Waktu')
                        ->description('Atur era dan urutan kronologis.')
                        ->schema([
                            TextInput::make('year')
                                ->label('Tahun / Era')
                                ->helperText('Contoh: 1614 atau Era Mataram.'),
                            TextInput::make('order_sequence')
                                ->label('Urutan')
                                ->helperText('Angka urutan untuk diurutkan di garis waktu (contoh: 1, 2, 3).')
                                ->required()
                                ->numeric()
                                ->default(0),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
