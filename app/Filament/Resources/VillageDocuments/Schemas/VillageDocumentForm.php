<?php

namespace App\Filament\Resources\VillageDocuments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Schema;

class VillageDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Nama Dokumen')
                    ->required()
                    ->maxLength(255),
                Select::make('document_category_id')
                    ->relationship('category', 'name')
                    ->label('Kategori')
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kategori'),
                    ])
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                FileUpload::make('file_paths')
                    ->label('File Dokumen')
                    ->directory('village-documents')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240) // 10MB
                    ->multiple()
                    ->downloadable()
                    ->preserveFilenames()
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('requirement_image_path')
                    ->label('Gambar Persyaratan / SOP')
                    ->image()
                    ->directory('village-documents/requirements')
                    ->maxSize(5120) // 5MB
                    ->columnSpanFull(),
                RichEditor::make('requirements_text')
                    ->label('Keterangan Persyaratan (Opsional)')
                    ->columnSpanFull(),
            ]);
    }
}
