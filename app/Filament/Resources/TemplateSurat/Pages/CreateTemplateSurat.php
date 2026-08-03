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
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class CreateTemplateSurat extends CreateRecord
{
    protected static string $resource = TemplateSuratResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1])->schema([
                Section::make('Upload Template Word')
                    ->description('Upload file .docx untuk dikonversi ke HTML secara otomatis. Atau isi konten HTML langsung.')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Template')
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
                            ->default(true),

                        FileUpload::make('file_docx_upload')
                            ->label('File Word (.docx)')
                            ->helperText('Upload file .docx untuk dikonversi ke HTML. Opsional — Anda juga bisa langsung mengisi editor di bawah.')
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
                                    $path = Storage::disk('public')->path($state);
                                    $html = app(DocxConverterService::class)->convert($path);
                                    $set('konten_html', $html);
                                    $set('file_docx_path', $state);
                                } catch (\Throwable $e) {
                                    Notification::make()
                                        ->title('Gagal Konversi DOCX')
                                        ->body($e->getMessage())
                                        ->danger()
                                        ->send();
                                }
                            }),

                        RichEditor::make('konten_html')
                            ->label('Konten Template (HTML)')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'alignLeft', 'alignCenter', 'alignRight', 'alignJustify',
                                'bulletList', 'orderedList',
                                'blockquote', 'undo', 'redo',
                            ])
                            ->required()
                            ->columnSpanFull(),
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
}
