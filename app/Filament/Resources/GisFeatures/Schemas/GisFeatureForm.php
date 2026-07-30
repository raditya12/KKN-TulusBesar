<?php

namespace App\Filament\Resources\GisFeatures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GisFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Titik Lokasi')
                    ->helperText('Contoh: Tiang Listrik PJU RT 01.')
                    ->required(),
                Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'PJU' => 'PJU (Penerangan Jalan)',
                        'Sampah' => 'Tempat Sampah',
                        'Peternakan' => 'Peternakan',
                        'Fasilitas Umum' => 'Fasilitas Umum',
                    ])
                    ->required(),
                Textarea::make('description')
                    ->label('Keterangan Singkat')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->label('Garis Lintang (Latitude)')
                    ->numeric(),
                TextInput::make('longitude')
                    ->label('Garis Bujur (Longitude)')
                    ->numeric(),
            ]);
    }
}
