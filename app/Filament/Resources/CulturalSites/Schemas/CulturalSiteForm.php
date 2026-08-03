<?php

namespace App\Filament\Resources\CulturalSites\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CulturalSiteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Grid::make(['default' => 1, 'lg' => 2])->schema([
                    Section::make('Informasi Situs')
                        ->description('Data utama situs budaya atau wisata.')
                        ->columns(2)
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Situs')
                                ->helperText('Contoh: Pesarean Senopati Mangun Yudho.')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->helperText('Terisi otomatis.')
                                ->required(),
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan lengkap nilai sejarah atau daya tarik situs ini.')
                                ->fileAttachmentsDirectory('cultural-sites-images')
                                ->extraInputAttributes(['style' => 'min-height: 250px;'])
                                ->columnSpanFull(),
                            Select::make('category')
                                ->label('Kategori')
                                ->options(function (\Filament\Forms\Components\Select $component) {
                                    $defaults = [
                                        'sejarah' => 'Sejarah & Religi',
                                        'budaya' => 'Seni & Tradisi',
                                    ];
                                    $existing = \App\Models\CulturalSite::query()
                                        ->whereNotNull('category')
                                        ->distinct()
                                        ->pluck('category', 'category')
                                        ->toArray();

                                    unset($existing['sejarah'], $existing['budaya']);

                                    $options = $defaults + $existing;

                                    // Make sure the currently selected state is present in the options array
                                    // so that Filament validation allows newly created (but not yet saved) categories.
                                    $state = $component->getState();
                                    if ($state && !isset($options[$state])) {
                                        $options[$state] = $state;
                                    }

                                    return $options;
                                })
                                ->default('sejarah')
                                ->createOptionForm([
                                    TextInput::make('new_category')
                                        ->label('Nama Kategori Baru')
                                        ->required()
                                        ->maxLength(255),
                                ])
                                ->createOptionUsing(function (array $data): string {
                                    return $data['new_category'];
                                })
                                ->required(),
                            Select::make('status')
                                ->label('Status')
                                ->options(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'])
                                ->default('active')
                                ->required(),
                        ])->columnSpan(1),

                    Section::make('Lokasi & Media')
                        ->description('Titik koordinat dan foto situs.')
                        ->columns(1)
                        ->schema([
                            \Dotswan\MapPicker\Fields\Map::make('location')
                                ->label('Pilih Lokasi di Peta')
                                ->helperText('Geser penanda merah pada peta untuk menentukan lokasi yang tepat.')
                                ->columnSpanFull()
                                ->defaultLocation(latitude: -8.0093, longitude: 112.7666) // Pusat Desa Tulusbesar
                                ->afterStateUpdated(function (Set $set, ?array $state): void {
                                    $set('latitude', $state['lat'] ?? null);
                                    $set('longitude', $state['lng'] ?? null);
                                })
                                ->afterStateHydrated(function ($state, $record, Set $set): void {
                                    if ($record && $record->latitude && $record->longitude) {
                                        $set('location', ['lat' => $record->latitude, 'lng' => $record->longitude]);
                                    }
                                })
                                ->extraStyles([
                                    'min-height: 60vh',
                                    'border-radius: 12px'
                                ])
                                ->showMarker()
                                ->draggable()
                                ->zoom(14)
                                ->live(onBlur: true),
                            \Filament\Forms\Components\Hidden::make('latitude'),
                            \Filament\Forms\Components\Hidden::make('longitude'),
                            FileUpload::make('image_path')
                                ->label('Foto Situs')
                                ->helperText('Unggah foto lokasi.')
                                ->disk('public')
                                ->image()
                                ->directory('cultural-sites')
                                ->imagePreviewHeight('250')
                                ->maxSize(5120)
                                ->columnSpanFull(),
                        ])->columnSpan(1),
                ])->columnSpan(3),
            ]);
    }
}
