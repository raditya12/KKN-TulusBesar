<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Models\TemplateSurat as TemplateSuratModel;
use App\Services\Surat\DocxConverterService;
use App\Services\Surat\PlaceholderService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\Storage;

class CreateTemplateSurat extends CreateRecord
{
    protected static string $resource = TemplateSuratResource::class;

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::Full;
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1])->schema([
                // === TOP CARD: Upload File & Metadata ===
                Section::make('Upload File & Informasi Template')
                    ->description('Unggah dokumen .docx atau isi data template di bawah ini.')
                    ->schema([
                        Grid::make(['default' => 1, 'md' => 2])->schema([
                            // Left: Metadata fields
                            Grid::make(['default' => 1])->schema([
                                TextInput::make('judul')
                                    ->label('Judul Template')
                                    ->placeholder('Contoh: Template Surat Keterangan Domisili')
                                    ->required()
                                    ->maxLength(255),

                                Select::make('jenis_surat_id')
                                    ->label('Jenis Surat')
                                    ->relationship('jenisSurat', 'nama')
                                    ->required()
                                    ->searchable()
                                    ->preload(),

                                Toggle::make('is_active')
                                    ->label('Jadikan Template Aktif')
                                    ->helperText('Hanya satu template aktif per jenis surat.')
                                    ->default(true),
                            ]),

                            // Right: File Upload Dropzone
                            FileUpload::make('file_docx_upload')
                                ->label('File Word (.docx)')
                                ->helperText('Upload file .docx untuk konversi otomatis ke HTML & Live Preview.')
                                ->disk('public')
                                ->directory('templates')
                                ->acceptedFileTypes(['application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                                ->maxSize(10240)
                                ->live()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if (! $state) {
                                        return;
                                    }

                                    try {
                                        $file = is_array($state) ? reset($state) : $state;

                                        if (! $file) {
                                            return;
                                        }

                                        $path = null;

                                        if (is_object($file) && method_exists($file, 'getRealPath')) {
                                            $path = $file->getRealPath();
                                        } elseif (is_string($file)) {
                                            $publicPath = Storage::disk('public')->path($file);
                                            if (file_exists($publicPath)) {
                                                $path = $publicPath;
                                            } else {
                                                $localPath = storage_path('app/' . $file);
                                                $livewireTmp = storage_path('app/livewire-tmp/' . $file);
                                                if (file_exists($localPath)) {
                                                    $path = $localPath;
                                                } elseif (file_exists($livewireTmp)) {
                                                    $path = $livewireTmp;
                                                }
                                            }
                                        }

                                        if (! $path || ! file_exists($path)) {
                                            throw new \RuntimeException('File DOCX tidak dapat dibaca dari penyimpanan sementara.');
                                        }

                                        $html = app(DocxConverterService::class)->convert($path);

                                        if (! empty($html)) {
                                            $set('konten_html', $html);

                                            if (is_string($file)) {
                                                $set('file_docx_path', $file);
                                            }

                                            Notification::make()
                                                ->title('Berhasil Mengonversi DOCX')
                                                ->body('Isi dokumen berhasil dimuat ke editor dan live preview.')
                                                ->success()
                                                ->send();
                                        }
                                    } catch (\Throwable $e) {
                                        Notification::make()
                                            ->title('Gagal Konversi DOCX')
                                            ->body($e->getMessage())
                                            ->danger()
                                            ->persistent()
                                            ->send();
                                    }
                                }),
                        ]),
                    ]),

                // === BOTTOM CARD: Editor, Live Preview & Placeholder Panel ===
                Grid::make(['default' => 1, 'lg' => 3])->schema([
                    // Left 2 Columns: Preview & Editor
                    Section::make('Pratinjau & Validasi Template')
                        ->description('Lihat hasil tampilan cetak fisik A4 dan sunting isi template secara langsung.')
                        ->schema([
                            View::make('filament.template-surat.live-preview')
                                ->columnSpanFull(),

                            RichEditor::make('konten_html')
                                ->label('Editor Konten Template (HTML)')
                                ->id('template-rich-editor')
                                ->toolbarButtons([
                                    'blockquote',
                                    'bold',
                                    'bulletList',
                                    'codeBlock',
                                    'h2',
                                    'h3',
                                    'italic',
                                    'link',
                                    'orderedList',
                                    'redo',
                                    'strike',
                                    'undo',
                                ])
                                ->live()
                                ->extraInputAttributes(['id' => 'template-editor-input'])
                                ->required()
                                ->columnSpanFull(),
                        ])->columnSpan(2),

                    // Right 1 Column: Placeholder Reference Panel
                    Section::make('Master Placeholder')
                        ->description('Klik item di bawah untuk menyisipkan variabel.')
                        ->schema([
                            View::make('filament.template-surat.placeholder-panel')
                                ->viewData([
                                    'placeholders' => \App\Models\MasterPlaceholder::orderBy('kategori')->orderBy('nama_field')->get()->groupBy('kategori'),
                                ]),
                        ])->columnSpan(1),
                ]),
            ]),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $placeholderService = app(PlaceholderService::class);
        $invalidPlaceholders = $placeholderService->validatePlaceholders($data['konten_html'] ?? '');

        if (! empty($invalidPlaceholders)) {
            Notification::make()
                ->title('Placeholder Tidak Valid')
                ->body('Placeholder berikut tidak terdaftar: '.implode(', ', $invalidPlaceholders))
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }

        // Deactivate competing templates if this one is active
        if (! empty($data['is_active'])) {
            TemplateSuratModel::where('jenis_surat_id', $data['jenis_surat_id'])
                ->update(['is_active' => false]);
        }

        // Remove virtual field
        unset($data['file_docx_upload']);

        $data['created_by'] = auth()->id();

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
