<?php

namespace App\Filament\Resources\Publications\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class PublicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('youtube_url')
                    ->url(),
                FileUpload::make('cover_image')
                    ->label('Foto Cover (Opsional)')
                    ->image()
                    ->disk('public')
                    ->directory('publications')
                    ->columnSpanFull(),
                FileUpload::make('images')
                    ->label('Galeri Foto Tambahan (Bisa Banyak)')
                    ->image()
                    ->multiple()
                    ->disk('public')
                    ->directory('publications')
                    ->columnSpanFull(),
                RichEditor::make('description')
                    ->columnSpanFull(),
                Select::make('category')
                    ->options([
                        'Inovasi Digital' => 'Inovasi Digital',
                        'Berita Desa' => 'Berita Desa',
                        'Tutorial' => 'Tutorial',
                        'Kegiatan KKN' => 'Kegiatan KKN',
                        'Umum' => 'Umum',
                    ])
                    ->required()
                    ->default('Umum'),
                Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }
}
