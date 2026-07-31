<?php

namespace App\Filament\Resources\LocationSites\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class LocationSiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Lokasi')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Select::make('location_category_id')
                    ->label('Kategori Peta')
                    ->relationship('locationCategory', 'name')
                    ->required(),
                TextInput::make('whatsapp_number')
                    ->label('Nomor WhatsApp (Opsional)')
                    ->tel()
                    ->placeholder('Contoh: 6281234567890'),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                Grid::make(2)->schema([
                    TextInput::make('latitude')
                        ->id('latitude')
                        ->numeric()
                        ->minValue(-90)
                        ->maxValue(90)
                        ->step(0.00000001),
                    TextInput::make('longitude')
                        ->id('longitude')
                        ->numeric()
                        ->minValue(-180)
                        ->maxValue(180)
                        ->step(0.00000001),
                ]),
                \Filament\Schemas\Components\View::make('filament.forms.components.map-picker')
                    ->columnSpanFull(),
                FileUpload::make('image_path')
                    ->label('Gambar Utama (Cover)')
                    ->image()
                    ->directory('location_sites'),
                FileUpload::make('gallery')
                    ->label('Galeri Tambahan')
                    ->image()
                    ->multiple()
                    ->directory('location_sites_gallery')
                    ->panelLayout('grid'),
                Select::make('status')
                    ->options(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'])
                    ->default('active')
                    ->required(),
            ]);
    }
}
