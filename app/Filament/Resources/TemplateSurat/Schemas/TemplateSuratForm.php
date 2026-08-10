<?php

namespace App\Filament\Resources\TemplateSurat\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Illuminate\Support\Facades\Storage;
use App\Services\DocxService;

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

                    Section::make('Detail Template')
                        ->columnSpan([
                            'default' => 'full',
                            'lg'      => fn ($get) => filled($get('file_docx')) ? 1 : 'full',
                        ])
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
                                ->maxSize(10240) // 10MB max
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

                    Section::make('Preview Template')
                        ->columnSpan(['default' => 'full', 'lg' => 1])
                        ->extraAttributes(['class' => 'ts-preview-section'])
                        ->visible(fn ($get) => filled($get('file_docx')))
                        ->schema([
                            View::make('filament.pages.partials.template-preview-modal')
                                ->viewData(function ($get) {
                                    $state = $get('file_docx');
                                    if (is_array($state)) {
                                        $state = array_key_first($state) ?: (array_values($state)[0] ?? null);
                                    }

                                    if (!$state) {
                                        return ['pdfUrl' => null];
                                    }

                                    $docxPath = null;
                                    if ($state instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                                        $docxPath = $state->getRealPath();
                                    } elseif ($state instanceof \Illuminate\Http\UploadedFile) {
                                        $docxPath = $state->getRealPath();
                                    } else {
                                        $docxPath = Storage::disk('public')->path($state);
                                        if (!file_exists($docxPath)) {
                                            // Try local disk (Livewire default temp location)
                                            $docxPath = Storage::disk('local')->path($state);
                                        }
                                    }

                                    if (!$docxPath || !file_exists($docxPath)) {
                                        return ['pdfUrl' => null];
                                    }

                                    /** @var DocxService $docxService */
                                    $docxService = app(DocxService::class);

                                    Storage::disk('public')->makeDirectory('temp-template-preview');
                                    // Use a unique name for this file based on size/mtime or random string
                                    $pdfName = md5($docxPath . (file_exists($docxPath) ? filemtime($docxPath) : time())) . '.pdf';
                                    $pdfPath = 'temp-template-preview/' . $pdfName;
                                    $fullPdfPath = Storage::disk('public')->path($pdfPath);

                                    if (!file_exists($fullPdfPath)) {
                                        $docxService->generatePdfFromDocx($docxPath, $fullPdfPath, useNativeWord: true);
                                    }

                                    return [
                                        'pdfUrl' => Storage::url($pdfPath)
                                    ];
                                })
                        ])
                ])
        ]);
    }
}
