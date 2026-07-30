<?php

namespace App\Filament\Resources\Umkms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Filament\Schemas\Schema;

class UmkmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Informasi Usaha')
                        ->description('Data profil dan kategori UMKM.')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Usaha')
                                ->helperText('Contoh: Sentra Tahu Tulusbesar.')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->helperText('Otomatis terisi dari nama usaha.')
                                ->required(),
                            TextInput::make('category')
                                ->label('Kategori Usaha')
                                ->helperText('Contoh: Kuliner, Kriya, Pertanian.'),
                            Textarea::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan singkat tentang usaha ini.')
                                ->columnSpanFull(),
                        ])->columnSpan(2),
                        
                    Section::make('Galeri')
                        ->description('Unggah dokumentasi usaha.')
                        ->schema([
                            FileUpload::make('image_path')
                                ->label('Foto Usaha')
                                ->helperText('Unggah foto produk atau tempat usaha.')
                                ->image()
                                ->directory('umkm-images'),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
