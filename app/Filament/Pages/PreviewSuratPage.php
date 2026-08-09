<?php

namespace App\Filament\Pages;

use App\Models\Surat;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class PreviewSuratPage extends Page
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';

    protected string $view = 'filament.pages.preview-surat-page';

    protected static ?string $title = 'Preview Hasil Surat';

    protected static bool $shouldRegisterNavigation = false;

    public ?int $record = null;
    public ?Surat $surat = null;

    public function mount(): void
    {
        $this->record = request()->query('record');
        if (!$this->record) {
            abort(404, 'Surat ID tidak ditemukan');
        }
        $this->surat = Surat::findOrFail($this->record);
    }

    public function editData()
    {
        return redirect()->route('filament.admin.pages.pembuatan-surat-page', ['surat_id' => $this->surat->id]);
    }

    public function downloadDocx(): ?BinaryFileResponse
    {
        if ($this->surat && $this->surat->file_docx && Storage::disk('public')->exists($this->surat->file_docx)) {
            return response()->download(Storage::disk('public')->path($this->surat->file_docx));
        }
        return null;
    }

    public function downloadPdf(): ?BinaryFileResponse
    {
        if ($this->surat && $this->surat->file_pdf && Storage::disk('public')->exists($this->surat->file_pdf)) {
            return response()->download(Storage::disk('public')->path($this->surat->file_pdf));
        }
        return null;
    }

    public function getPdfUrlProperty(): ?string
    {
        if ($this->surat && $this->surat->file_pdf) {
            return Storage::url($this->surat->file_pdf);
        }
        return null;
    }
}
