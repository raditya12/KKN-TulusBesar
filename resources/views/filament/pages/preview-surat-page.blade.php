<x-filament-panels::page>
    <x-filament::section>
        <div style="display: flex; gap: 1rem; align-items: center; justify-content: center; margin-bottom: 1.5rem; flex-wrap: wrap;">

            @if($this->isTempPreview)
                {{-- Simpan ke Arsip — hanya tampil sebelum tersimpan --}}
                <x-filament::button
                    wire:click="simpanArsip"
                    color="success"
                    icon="heroicon-o-archive-box-arrow-down"
                >
                    Simpan ke Arsip
                </x-filament::button>
            @endif

            <x-filament::button
                wire:click="editData"
                color="warning"
                icon="heroicon-o-pencil-square"
            >
                Edit Data
            </x-filament::button>

            <x-filament::button
                wire:click="downloadDocx"
                color="primary"
                icon="heroicon-o-document-text"
            >
                Download Word
            </x-filament::button>


        </div>

        @if($this->isTempPreview)
            <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #fef9c3; border: 1px solid #fde047; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <x-filament::icon icon="heroicon-o-exclamation-triangle" style="width:1.25rem;height:1.25rem;color:#ca8a04;flex-shrink:0;" />
                <span style="font-size: 0.875rem; color: #854d0e;">
                    Surat ini belum disimpan ke arsip. Klik <strong>Simpan ke Arsip</strong> jika sudah sesuai.
                </span>
            </div>
        @endif

        @if($this->pdfUrl)
            <div style="height: 75vh; width: 100%; border-radius: 0.5rem; overflow: hidden; border: 1px solid #e5e7eb; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
                <iframe
                    src="{{ $this->pdfUrl }}#toolbar=0&navpanes=0&scrollbar=1"
                    style="width: 100%; height: 100%; border: none; background-color: #f3f4f6;"
                ></iframe>
            </div>
        @else
            <div style="padding: 3rem; text-align: center; color: #6b7280; background-color: #f9fafb; border-radius: 0.5rem; border: 1px dashed #d1d5db;">
                <p style="font-size: 1.125rem; font-weight: 500;">Preview PDF tidak tersedia.</p>
                <p style="margin-top: 0.5rem; font-size: 0.875rem;">Dokumen mungkin gagal di-generate atau belum dikonversi.</p>
            </div>
        @endif
    </x-filament::section>
</x-filament-panels::page>
