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
            TextInput::make('nama_surat')
                ->label('Nama Surat')
                ->placeholder('Contoh: Surat Keterangan Domisili')
                ->required()
                ->maxLength(255),

            TextInput::make('kode_surat')
                ->label('Kode Surat')
                ->placeholder('Contoh: SKD')
                ->required()
                ->maxLength(50)
                ->unique(ignoreRecord: true),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->placeholder('Deskripsi singkat mengenai jenis surat ini...')
                ->rows(3)
                ->maxLength(1000)
                ->nullable(),

            Toggle::make('is_active')
                ->label('Status Aktif')
                ->default(true)
                ->helperText('Nonaktifkan jika jenis surat ini tidak lagi digunakan.'),
        ]);
    }
}
