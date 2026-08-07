<?php

namespace App\Filament\Resources\TemplateSurat\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TemplateSuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('jenis_surat_id')
                ->label('Jenis Surat')
                ->relationship('jenisSurat', 'nama_surat')
                ->required()
                ->searchable()
                ->preload(),

            FileUpload::make('file_docx')
                ->label('File Template (DOCX)')
                ->directory('template-surat')
                ->disk('public')
                ->acceptedFileTypes([
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                ])
                ->maxSize(10240) // 10MB max
                ->required()
                ->downloadable()
                ->preserveFilenames()
                ->helperText('Upload file template Word resmi dalam format .docx'),

            Toggle::make('is_active')
                ->label('Status Aktif')
                ->default(true)
                ->helperText('Jika diaktifkan, template aktif sebelumnya untuk jenis surat yang sama akan otomatis dinonaktifkan.'),
        ]);
    }
}
