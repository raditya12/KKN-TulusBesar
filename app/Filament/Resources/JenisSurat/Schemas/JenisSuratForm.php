<?php

namespace App\Filament\Resources\JenisSurat\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class JenisSuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('nama')
                ->label('Nama Jenis Surat')
                ->required()
                ->maxLength(255),

            TextInput::make('kode')
                ->label('Kode')
                ->helperText('Kode unik tanpa spasi, misal: skd, sktm_sekolah')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50)
                ->rules(['regex:/^[a-z0-9_]+$/']),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->rows(3)
                ->maxLength(500),

            Toggle::make('is_active')
                ->label('Aktif')
                ->default(true),
        ]);
    }
}
