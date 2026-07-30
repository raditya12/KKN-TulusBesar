<?php

namespace App\Filament\Resources\GisFeatures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class GisFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Informasi Fasilitas')
                        ->description('Data fasilitas umum atau titik penting.')
                        ->schema([
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
                        ])->columnSpan(2),
                        
                    Section::make('Titik Koordinat')
                        ->description('Data spasial lokasi.')
                        ->schema([
                            TextInput::make('latitude')
                                ->label('Garis Lintang (Latitude)')
                                ->numeric(),
                            TextInput::make('longitude')
                                ->label('Garis Bujur (Longitude)')
                                ->numeric(),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
