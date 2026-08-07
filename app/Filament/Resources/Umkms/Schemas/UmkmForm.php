<?php

namespace App\Filament\Resources\Umkms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class UmkmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1])->schema([
                    Section::make('Informasi Usaha')
                        ->description('Data profil dan kategori UMKM.')
                        ->columns(['default' => 1, 'md' => 2])
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
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan lengkap tentang usaha ini beserta keunggulannya.')
                                ->fileAttachmentsDirectory('umkm-images')
                                ->extraInputAttributes(['style' => 'min-height: 250px;'])
                                ->columnSpanFull(),
                            TextInput::make('category')
                                ->label('Kategori Usaha')
                                ->helperText('Contoh: Kuliner, Kriya, Pertanian.')
                                ->columnSpanFull(),
                        ])->columnSpanFull(),

                    Section::make('Lokasi & Media')
                        ->description('Titik koordinat dan foto usaha.')
                        ->columns(['default' => 1, 'md' => 2])
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
                            ])->columnSpanFull(),
                            FileUpload::make('images')
                                ->multiple()
                                ->reorderable()
                                ->label('Foto Usaha')
                                ->helperText('Unggah foto produk atau tempat usaha.')
                                ->disk('public')
                                ->image()
                                ->directory('umkm-images')
                                ->imagePreviewHeight('250')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(5120)
                                ->columnSpanFull(),
                        ])->columnSpanFull(),
                ]),
            ]);
    }
}
