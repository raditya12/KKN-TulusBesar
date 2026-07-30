<?php

namespace App\Filament\Resources\VillageProfiles\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class VillageProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('visi')
                    ->label('Visi Desa')
                    ->columnSpanFull(),
                Textarea::make('misi')
                    ->label('Misi Desa')
                    ->columnSpanFull(),
                Textarea::make('sejarah')
                    ->label('Sejarah Singkat')
                    ->columnSpanFull(),
                TextInput::make('total_population')
                    ->label('Total Penduduk')
                    ->helperText('Hanya angka, contoh: 6543.')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('area_size')
                    ->label('Luas Wilayah (Km2)')
                    ->helperText('Hanya angka, contoh: 4439.')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
