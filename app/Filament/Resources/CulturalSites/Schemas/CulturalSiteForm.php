<?php

namespace App\Filament\Resources\CulturalSites\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CulturalSiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Situs')
                    ->helperText('Contoh: Pesarean Senopati Mangun Yudho.')
                    ->required(),
                TextInput::make('slug')
                    ->label('Slug')
                    ->helperText('Terisi otomatis.')
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->helperText('Ceritakan nilai sejarah atau daya tarik situs ini.')
                    ->columnSpanFull(),
                TextInput::make('latitude')
                    ->label('Garis Lintang (Latitude)')
                    ->numeric(),
                TextInput::make('longitude')
                    ->label('Garis Bujur (Longitude)')
                    ->numeric(),
                FileUpload::make('image_path')
                    ->label('Foto Situs')
                    ->helperText('Unggah foto lokasi.')
                    ->image(),
                Select::make('status')
                    ->label('Status')
                    ->options(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
