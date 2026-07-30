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
                Grid::make(['default' => 1, 'md' => 3])->schema([
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
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan lengkap tentang usaha ini beserta keunggulannya.')
                                ->fileAttachmentsDirectory('umkm-images')
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
