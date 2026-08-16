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
                        TextInput::make('category_name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Kategori'),
                    ])
                    ->createOptionUsing(function (array $data): int {
                        return \App\Models\DocumentCategory::create(['name' => $data['category_name']])->id;
                    })
                    ->required(),
                Textarea::make('description')
                    ->label('Deskripsi')
                    ->columnSpanFull(),
                FileUpload::make('file_paths')
                    ->label('File Dokumen')
                    ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240) // 10MB
                    ->multiple()
                    ->downloadable()
                    ->preserveFilenames()
                    ->saveUploadedFileUsing(function (\Illuminate\Http\UploadedFile $file): string {
                        $filename = $file->getClientOriginalName();
                        $path = 'village-documents/' . $filename;
                        \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                        return $path;
                    })
                    ->required()
                    ->columnSpanFull(),
                FileUpload::make('requirement_image_path')
                    ->label('Gambar Persyaratan / SOP')
                    ->image()
                    ->maxSize(5120) // 5MB
                    ->saveUploadedFileUsing(function (\Illuminate\Http\UploadedFile $file): string {
                        $filename = $file->getClientOriginalName();
                        $path = 'village-documents/requirements/' . $filename;
                        \Illuminate\Support\Facades\Storage::disk('public')->put($path, file_get_contents($file->getRealPath()));
                        return $path;
                    })
                    ->columnSpanFull(),
                RichEditor::make('requirements_text')
                    ->label('Keterangan Persyaratan (Opsional)')
                    ->columnSpanFull(),
            ]);
    }
}
