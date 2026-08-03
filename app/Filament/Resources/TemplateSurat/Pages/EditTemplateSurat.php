<?php

namespace App\Filament\Resources\TemplateSurat\Pages;

use App\Filament\Resources\TemplateSurat\TemplateSuratResource;
use App\Models\MasterPlaceholder;
use App\Models\TemplateSurat as TemplateSuratModel;
use App\Services\Surat\PlaceholderService;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\View;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class EditTemplateSurat extends EditRecord
{
    protected static string $resource = TemplateSuratResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Grid::make(['default' => 1, 'lg' => 3])->schema([

                // === Left: Editor Panel (2/3 width) ===
                Section::make('Editor Template')
                    ->description('Edit konten surat. Klik placeholder di panel kanan untuk menyisipkan.')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul Template')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Select::make('jenis_surat_id')
                            ->label('Jenis Surat')
                            ->relationship('jenisSurat', 'nama')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Jadikan Template Aktif')
                            ->helperText('Hanya satu template aktif per jenis surat yang akan digunakan.')
                            ->columnSpanFull(),

                        RichEditor::make('konten_html')
                            ->label('Konten Template')
                            ->id('template-rich-editor')
                            ->toolbarButtons([
                                'bold', 'italic', 'underline', 'strike',
                                'h2', 'h3',
                                'alignLeft', 'alignCenter', 'alignRight', 'alignJustify',
                                'bulletList', 'orderedList',
                                'blockquote',
                                'undo', 'redo',
                            ])
                            ->extraInputAttributes(['id' => 'template-editor-input'])
                            ->columnSpanFull()
                            ->required(),
                    ])->columnSpan(2),

                // === Right: Placeholder Panel (1/3 width) ===
                Section::make('Daftar Placeholder')
                    ->description('Klik untuk menyisipkan ke posisi kursor.')
                    ->schema([
                        View::make('filament.template-surat.placeholder-panel')
                            ->viewData([
                                'placeholders' => MasterPlaceholder::orderBy('kategori')->orderBy('nama_field')->get()->groupBy('kategori'),
                            ]),
                    ])->columnSpan(1),
            ]),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn () => route('template-surat.preview', $this->record))
                ->openUrlInNewTab(),

            Action::make('download_docx')
                ->label('Download DOCX')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('gray')
                ->visible(fn () => $this->record->file_docx_path !== null)
                ->action(function () {
                    return Storage::disk('public')->download($this->record->file_docx_path);
                }),

            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $placeholderService = app(PlaceholderService::class);
        $invalidPlaceholders = $placeholderService->validatePlaceholders($data['konten_html'] ?? '');

        if (! empty($invalidPlaceholders)) {
            Notification::make()
                ->title('Placeholder Tidak Valid')
                ->body('Placeholder berikut tidak terdaftar: '.implode(', ', $invalidPlaceholders).'. Harap daftarkan terlebih dahulu di Master Placeholder.')
                ->danger()
                ->persistent()
                ->send();

            $this->halt();
        }

        // If set as active, deactivate other templates for the same jenis_surat
        if (! empty($data['is_active']) && $data['is_active']) {
            TemplateSuratModel::where('jenis_surat_id', $data['jenis_surat_id'])
                ->where('id', '!=', $this->record->id)
                ->update(['is_active' => false]);
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
