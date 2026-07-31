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
            ->components([
                Grid::make(['default' => 1, 'md' => 3])->schema([
                    Section::make('Informasi Situs')
                        ->description('Data utama situs budaya atau wisata.')
                        ->schema([
                            TextInput::make('name')
                                ->label('Nama Situs')
                                ->helperText('Contoh: Pesarean Senopati Mangun Yudho.')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                            TextInput::make('slug')
                                ->label('Slug')
                                ->helperText('Terisi otomatis.')
                                ->required(),
                            RichEditor::make('description')
                                ->label('Deskripsi')
                                ->helperText('Ceritakan lengkap nilai sejarah atau daya tarik situs ini.')
                                ->fileAttachmentsDirectory('cultural-sites-images')
                                ->columnSpanFull(),
                            Select::make('status')
                                ->label('Status')
                                ->options(['active' => 'Aktif', 'inactive' => 'Tidak Aktif'])
                                ->default('active')
                                ->required(),
                        ])->columnSpan(2),

                    Section::make('Lokasi & Media')
                        ->description('Titik koordinat dan foto situs.')
                        ->schema([
                            TextInput::make('latitude')
                                ->label('Garis Lintang (Latitude)')
                                ->numeric(),
                            TextInput::make('longitude')
                                ->label('Garis Bujur (Longitude)')
                                ->numeric(),
                            FileUpload::make('image_path')
                                ->label('Foto Situs')
                                ->helperText('Unggah foto lokasi.')
                                ->disk('public')
                                ->image()
                                ->directory('cultural-sites')
                                ->imagePreviewHeight('200')
                                ->maxSize(5120),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
