<?php

namespace App\Filament\Resources\GisFeatures\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class GisFeatureForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->schema([
                    Section::make('Informasi Fasilitas')
                        ->description('Data fasilitas umum atau titik penting.')
                        ->schema([
                            Grid::make(2)->schema([
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
                            ]),
                            Textarea::make('description')
                                ->label('Keterangan Singkat')
                                ->columnSpanFull(),
                        ]),

                    Section::make('Titik Koordinat')
                        ->description('Data spasial lokasi.')
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('map_preview')
                                ->hiddenLabel()
                                ->content(view('filament.forms.components.map-preview'))
                                ->columnSpanFull(),
                            Grid::make(2)->schema([
                                TextInput::make('latitude')
                                    ->label('Garis Lintang (Latitude)')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->helperText('Bisa diisi manual atau klik dari peta.'),
                                TextInput::make('longitude')
                                    ->label('Garis Bujur (Longitude)')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->helperText('Bisa diisi manual atau klik dari peta.'),
                            ]),
                        ]),
                ]),
            ]);
    }
}
