<?php

namespace App\Filament\Resources\TemplateSurat\Schemas;

use App\Services\DocxService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class TemplateSuratForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'lg' => 2])
                ->columnSpan('full')
                ->extraAttributes(['class' => 'ts-form-grid'])
                ->schema([
                    // Inject scoped CSS — spans full width, zero visual height
                    View::make('filament.pages.partials.template-form-styles')
                        ->columnSpan('full'),

                    // ── KOLOM KIRI: Detail Template + Data yang Ditemukan ──
                    // Dibungkus dalam Grid 1 kolom agar tidak ada gap besar
                    Grid::make(1)
                        ->columnSpan(['default' => 'full', 'lg' => 1])
                        ->extraAttributes(['style' => 'gap: 0.5rem;'])
                        ->schema([
                            Section::make('Detail Template')
                                ->schema([
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
                                        ->maxSize(10240)
                                        ->required()
                                        ->downloadable()
                                        ->preserveFilenames()
                                        ->helperText('Upload file template Word resmi dalam format .docx')
                                        ->live(),

                                    Toggle::make('is_active')
                                        ->label('Status Aktif')
                                        ->default(true)
                                        ->helperText('Jika diaktifkan, template aktif sebelumnya untuk jenis surat yang sama akan otomatis dinonaktifkan.'),
                                ]),

                            Section::make('Data yang Ditemukan')
                                ->visible(fn ($get) => filled($get('file_docx')))
                                ->schema([
                                    View::make('filament.pages.partials.template-placeholder-analysis')
                                        ->viewData(function ($get) {
                                            $docxPath = self::resolveDocxPath($get('file_docx'));
                                            if (! $docxPath) {
                                                return ['analysis' => null];
                                            }

                                            return ['analysis' => app(DocxService::class)->analyzePlaceholders($docxPath)];
                                        }),
                                ]),
                        ]),

                    // ── KOLOM KANAN: Preview PDF ──────────────────────────
                    Section::make('Preview Template')
                        ->columnSpan(['default' => 'full', 'lg' => 1])
                        ->extraAttributes(['class' => 'ts-preview-section'])
                        ->visible(fn ($get) => filled($get('file_docx')))
                        ->schema([
                            View::make('filament.pages.partials.template-preview-modal')
                                ->viewData(function ($get) {
                                    $docxPath = self::resolveDocxPath($get('file_docx'));
                                    if (! $docxPath) {
                                        return ['pdfUrl' => null];
                                    }

                                    $docxService = app(DocxService::class);
                                    Storage::disk('public')->makeDirectory('temp-template-preview');
                                    $pdfName     = md5($docxPath . filemtime($docxPath)) . '.pdf';
                                    $pdfPath     = 'temp-template-preview/' . $pdfName;
                                    $fullPdfPath = Storage::disk('public')->path($pdfPath);

                                    if (! file_exists($fullPdfPath)) {
                                        $docxService->generatePdfFromDocx($docxPath, $fullPdfPath, useNativeWord: true);
                                    }

                                    return ['pdfUrl' => Storage::url($pdfPath)];
                                }),
                        ]),
                ])
        ]);
    }

    /** Resolve a DOCX path from the FileUpload state (supports temp uploads and saved paths). */
    private static function resolveDocxPath(mixed $state): ?string
    {
        if (is_array($state)) {
            $state = array_key_first($state) ?: (array_values($state)[0] ?? null);
        }

        if (! $state) {
            return null;
        }

        if ($state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $state->getRealPath();
        }

        if ($state instanceof \Illuminate\Http\UploadedFile) {
            return $state->getRealPath();
        }

        $path = Storage::disk('public')->path($state);
        if (file_exists($path)) {
            return $path;
        }

        $path = Storage::disk('local')->path($state);

        return file_exists($path) ? $path : null;
    }
}
