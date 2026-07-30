<?php

namespace App\Filament\Resources\NewsArticles\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 3])->schema([
                    Section::make('Konten Berita')
                        ->description('Masukkan judul dan isi berita utama.')
                        ->schema([
                            TextInput::make('title')
                                ->label('Judul Berita')
                                ->helperText('Tuliskan judul berita yang menarik.')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state ?? ''))),
                            TextInput::make('slug')
                                ->label('Tautan (Slug)')
                                ->helperText('Terisi otomatis dari judul, atau isi manual dengan format-kata-kunci.')
                                ->required(),
                            RichEditor::make('content')
                                ->label('Isi Berita')
                                ->helperText('Tuliskan isi detail dari berita atau pengumuman.')
                                ->fileAttachmentsDirectory('news-images')
                                ->required()
                                ->columnSpanFull(),
                        ])->columnSpan(2),

                    Section::make('Media & Publikasi')
                        ->description('Kelola gambar dan tanggal rilis.')
                        ->schema([
                            FileUpload::make('image_path')
                                ->label('Gambar Utama')
                                ->helperText('Unggah gambar pendukung untuk berita ini (opsional).')
                                ->disk('public')
                                ->image()
                                ->directory('news-images')
                                ->imagePreviewHeight('200')
                                ->maxSize(5120),
                            DateTimePicker::make('published_at')
                                ->label('Tanggal Publikasi')
                                ->helperText('Kapan berita ini diterbitkan?'),
                        ])->columnSpan(1),
                ]),
            ]);
    }
}
