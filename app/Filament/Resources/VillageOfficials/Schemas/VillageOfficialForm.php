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
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required(),
                TextInput::make('position')
                    ->label('Jabatan')
                    ->required(),
                FileUpload::make('image_path')
                    ->label('Foto Profil')
                    ->directory('officials')
                    ->image(),
                TextInput::make('order')
                    ->label('Urutan Tampil')
                    ->helperText('Angka lebih kecil akan tampil lebih awal (contoh: 1 untuk Kades)')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
