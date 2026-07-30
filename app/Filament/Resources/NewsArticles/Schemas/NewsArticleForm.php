<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Schemas\Schema;

class NewsArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    Section::make('Konten Berita')
                        ->description('Masukkan judul dan isi berita utama.')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Berita')
                                ->helperText('Tuliskan judul berita yang menarik.')
                                ->required(),
                            TextInput::make('slug')
                                ->label('Tautan (Slug)')
                                ->helperText('Terisi otomatis dari judul, atau isi manual dengan format-kata-kunci.')
                                ->required(),
                            RichEditor::make('content')
                                ->label('Isi Berita')
                                ->helperText('Tuliskan isi detail dari berita atau pengumuman.')
                                ->required()
                                ->columnSpanFull(),
                        ])->columnSpan(2),
                        
                    Section::make('Media & Publikasi')
                        ->description('Kelola gambar dan tanggal rilis.')
                        ->schema([
                            FileUpload::make('image_path')
                                ->label('Gambar Utama')
                                ->helperText('Unggah gambar pendukung untuk berita ini (opsional).')
                                ->image(),
                            DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->helperText('Kapan berita ini diterbitkan?'),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
