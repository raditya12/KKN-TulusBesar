<?php

namespace App\Filament\Resources\JenisSurat\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class JenisSuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('kode_surat')
                ->label('Kode Surat')
                ->placeholder('Contoh: SKD, SKU')
                ->required()
                ->maxLength(255),
                
            TextInput::make('nama_surat')
                ->label('Nama Surat')
                ->placeholder('Contoh: Surat Keterangan Domisili')
                ->required()
                ->maxLength(255),

            Textarea::make('deskripsi')
                ->label('Deskripsi')
                ->placeholder('Deskripsi singkat mengenai jenis surat ini...')
                ->rows(3)
                ->maxLength(1000)
                ->nullable(),
        ]);
    }
}
