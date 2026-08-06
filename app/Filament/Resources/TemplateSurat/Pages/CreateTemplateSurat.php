<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Models\TemplateSurat as TemplateSuratModel;
use App\Services\Surat\DocxConverterService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
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
            Tabs::make('TemplateFormTabs')
                ->tabs([
                    Tab::make('Editor Template')
                        ->icon('heroicon-o-pencil-square')
                        ->schema([
                            Section::make('Informasi Template Surat')
                                ->description('Unggah file .docx atau isi data dasar template di bawah ini.')
                                ->schema([
                                    TextInput::make('judul')
                                        ->label('Judul Template')
                                        ->placeholder('Contoh: Template Surat Keterangan Domisili')
                                        ->required()
                                        ->maxLength(255),

                                    Grid::make(['default' => 1, 'md' => 2])->schema([
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

                                    FileUpload::make('file_docx_upload')
                                        ->label('File Word (.docx) — Opsional')
                                        ->helperText('Upload file .docx untuk konversi otomatis ke HTML.')
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
                                                        $localPath    = storage_path('app/' . $file);
                                                        $livewireTmp  = storage_path('app/livewire-tmp/' . $file);
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

                            Section::make('Editor Konten Template (HTML)')
                                ->description('Edit teks dan format HTML dokumen surat.')
                                ->schema([
                                    RichEditor::make('konten_html')
                                        ->label('Konten Template (HTML)')
                                        ->id('template-rich-editor')
                                        ->hintAction(
                                            \Filament\Actions\Action::make('autoDetectTags')
                                                ->label('⚡ Deteksi Otomatis Tag')
                                                ->tooltip('Otomatis mendeteksi kolom kosong seperti "Nama : ", "NIK : ", "Sekolah : " dan memasang tag {{nama}}, {{nik}}, dll.')
                                                ->action(function ($state, callable $set) {
                                                    if (empty($state)) {
                                                        return;
                                                    }
                                                    $processed = app(\App\Services\Surat\DocxConverterService::class)->cleanHtml($state);
                                                    $set('konten_html', $processed);
                                                    \Filament\Notifications\Notification::make()
                                                        ->title('Tag Berhasil Dideteksi Otomatis')
                                                        ->body('Label data yang kosong telah berhasil dipasangi tag template.')
                                                        ->success()
                                                        ->send();
                                                })
                                        )
                                        ->toolbarButtons([
                                            'bold',
                                            'italic',
                                            'underline',
                                            'strike',
                                            'bulletList',
                                            'orderedList',
                                            'link',
                                            'redo',
                                            'undo',
                                        ])
                                        ->live(onBlur: true)
                                        ->extraInputAttributes(['id' => 'template-editor-input'])
                                        ->required()
                                        ->columnSpanFull(),
                                ]),
                        ]),

                    Tab::make('Pratinjau Cetak A4')
                        ->icon('heroicon-o-eye')
                        ->schema([
                            View::make('filament.template-surat.live-preview')
                                ->columnSpanFull(),
                        ]),
                ])
                ->columnSpanFull(),
        ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
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
