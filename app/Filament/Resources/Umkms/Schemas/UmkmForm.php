<?php

namespace App\Filament\Resources\Umkms\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UmkmForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Usaha')
                    ->helperText('Contoh: Sentra Tahu Tulusbesar.')
                    ->required(),
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
                FileUpload::make('image_path')
                    ->label('Foto Usaha')
                    ->helperText('Unggah foto produk atau tempat usaha.')
                    ->image(),
            ]);
    }
}
