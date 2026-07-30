<?php

namespace App\Filament\Resources\CulturalSites\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class CulturalSiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Informasi Situs')
                        ->description('Data utama situs budaya atau wisata.')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Situs')
                                ->helperText('Contoh: Pesarean Senopati Mangun Yudho.')
                                ->required(),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->helperText('Terisi otomatis.')
                                ->required(),
                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan nilai sejarah atau daya tarik situs ini.')
                                ->columnSpanFull(),
                            Select::make('status')
                                ->label('Status')
                                ->options(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'])
                                ->default('active')
                                ->required(),
                        ])->columnSpan(2),
                        
                    Section::make('Lokasi & Media')
                        ->description('Titik koordinat dan foto situs.')
                        ->schema([
                            TextInput::make('latitude')
                                ->label('Garis Lintang (Latitude)')
                                ->numeric(),
                            TextInput::make('longitude')
                                ->label('Garis Bujur (Longitude)')
                                ->numeric(),
                            FileUpload::make('image_path')
                                ->label('Foto Situs')
                                ->helperText('Unggah foto lokasi.')
                                ->image(),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
