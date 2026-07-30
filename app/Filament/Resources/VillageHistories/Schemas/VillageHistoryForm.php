<?php

namespace App\Filament\Resources\VillageHistories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VillageHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('year')
                    ->label('Tahun / Era')
                    ->helperText('Contoh: 1614 atau Era Mataram.'),
                TextInput::make('title')
                    ->label('Judul Peristiwa')
                    ->helperText('Contoh: Pelarian Senopati.')
                    ->required(),
                Textarea::make('description')
                    ->label('Keterangan')
                    ->helperText('Ceritakan peristiwa yang terjadi pada era tersebut.')
                    ->columnSpanFull(),
                TextInput::make('order_sequence')
                    ->label('Urutan')
                    ->helperText('Angka urutan untuk diurutkan di garis waktu (contoh: 1, 2, 3).')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
