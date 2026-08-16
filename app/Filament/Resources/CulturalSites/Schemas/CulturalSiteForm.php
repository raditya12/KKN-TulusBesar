<?php

namespace App\Filament\Resources\CulturalSites\Schemas;

use App\Models\CulturalSite;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
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
                Grid::make(['default' => 1])->columnSpan('full')->schema([
                    Section::make('Informasi Situs')
                        ->description('Data utama situs budaya atau wisata.')
                        ->columns(['default' => 1, 'md' => 2])
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
                                ->extraInputAttributes(['style' => 'min-height: 250px;'])
                                ->columnSpanFull(),
                            Select::make('category')
                                ->label('Kategori')
                                ->options(function (Select $component) {
                                    $defaults = [
                                        'sejarah' => 'Sejarah & Religi',
                                        'budaya' => 'Seni & Tradisi',
                                    ];
                                    $existing = CulturalSite::query()
                                        ->whereNotNull('category')
                                        ->distinct()
                                        ->pluck('category', 'category')
                                        ->toArray();

                                    unset($existing['sejarah'], $existing['budaya']);

                                    $options = $defaults + $existing;

                                    // Make sure the currently selected state is present in the options array
                                    // so that Filament validation allows newly created (but not yet saved) categories.
                                    $state = $component->getState();
                                    if ($state && ! isset($options[$state])) {
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
                        ])->columnSpanFull(),

                    Section::make('Lokasi & Media')
                        ->description('Titik koordinat dan foto situs.')
                        ->columns(['default' => 1, 'md' => 2])
                        ->schema([
                            \Filament\Forms\Components\Placeholder::make('map_preview')
                                ->hiddenLabel()
                                ->content(view('filament.forms.components.map-preview'))
                                ->columnSpanFull(),
                            Grid::make(2)->schema([
                                TextInput::make('latitude')
                                    ->label('Garis Lintang (Latitude)')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->helperText('Bisa diisi manual atau klik dari peta.'),
                                TextInput::make('longitude')
                                    ->label('Garis Bujur (Longitude)')
                                    ->numeric()
                                    ->live(debounce: 500)
                                    ->helperText('Bisa diisi manual atau klik dari peta.'),
                            ])->columnSpanFull(),
                            FileUpload::make('images')
                                ->multiple()
                                ->reorderable()
                                ->label('Foto Situs')
                                ->helperText('Unggah foto lokasi.')
                                ->image()
                                ->directory('cultural-sites')
                                ->preserveFilenames()
                                ->imagePreviewHeight('250')
                                ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])
                                ->maxSize(5120)
                                ->columnSpanFull(),
                        ])->columnSpanFull(),
                ]),
            ]);
    }
}
