<?php

namespace App\Filament\Resources\VillageOfficials\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VillageOfficialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Informasi Perangkat Desa')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required(),
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->required(),
                        TextInput::make('order')
                            ->label('Urutan Tampil')
                            ->helperText('Angka lebih kecil akan tampil lebih awal (contoh: 1 untuk Kades)')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->columnSpanFull(),
                        FileUpload::make('image_path')
                            ->label('Foto Profil')
                            ->directory('officials')
                            ->image()
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
