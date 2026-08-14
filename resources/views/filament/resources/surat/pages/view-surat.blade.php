@php
    /** @var \App\Models\Surat $record */
    $record = $this->record;

    // Parse data JSON
    $dataJson = $record->data_json;
    if (is_string($dataJson)) {
        $dataJson = json_decode($dataJson, true) ?: [];
    }
    
    if (!is_array($dataJson)) {
        $dataJson = [];
    }

    // Reorder based on template placeholders
    $orderedData = [];
    $template = \App\Models\TemplateSurat::where('jenis_surat_id', $record->jenis_surat_id)
        ->where('is_active', true)
        ->first();

    if ($template && $template->file_docx && \Illuminate\Support\Facades\Storage::disk('public')->exists($template->file_docx)) {
        $docxService = app(\App\Services\DocxService::class);
        $placeholders = $docxService->extractPlaceholders(\Illuminate\Support\Facades\Storage::disk('public')->path($template->file_docx));
        
        foreach ($placeholders as $ph) {
            if (array_key_exists($ph, $dataJson)) {
                $orderedData[$ph] = $dataJson[$ph];
            }
        }
        // Append any remaining keys
        foreach ($dataJson as $k => $v) {
            if (!array_key_exists($k, $orderedData)) {
                $orderedData[$k] = $v;
            }
        }
    } else {
        $orderedData = $dataJson;
    }

@endphp

<x-filament-panels::page>
    <div class="surat-detail-wrapper">

        {{-- KOLOM KIRI --}}
        <div class="surat-col-kiri">

            {{-- Card: Informasi Arsip --}}
            <x-filament::section heading="Informasi Arsip">
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    <div>
                        <p class="surat-label">Nomor Surat</p>
                        <p class="surat-value font-bold">{{ $record->nomor_surat }}</p>
                    </div>
                    <div>
                        <p class="surat-label">Jenis Surat</p>
                        <div style="margin-top: 0.25rem;">
                            <x-filament::badge color="primary">
                                {{ $record->jenisSurat->nama_surat ?? '-' }}
                            </x-filament::badge>
                        </div>
                    </div>
                    <div>
                        <p class="surat-label">Nama Pemohon</p>
                        <p class="surat-value">{{ $record->nama_pemohon }}</p>
                    </div>
                    <div>
                        <p class="surat-label">Dibuat Pada</p>
                        <p class="surat-value">{{ $record->created_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                </div>
            </x-filament::section>

            {{-- Card: Data Form --}}
            <x-filament::section heading="Data Form">
                @if(is_array($orderedData) && count($orderedData) > 0)
                    <div class="surat-data-scroll">
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            @foreach($orderedData as $key => $value)
                                <div style="padding-bottom: 0.75rem; border-bottom: 1px solid #f3f4f6;">
                                    <p class="surat-label">{{ \Illuminate\Support\Str::headline($key) }}</p>
                                    <p class="surat-value">{{ $value ?: '-' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p style="font-size: 0.875rem; color: #9ca3af; font-style: italic;">Tidak ada data form.</p>
                @endif
            </x-filament::section>

        </div>

        {{-- KOLOM KANAN --}}
        <div class="surat-col-kanan">
            <x-filament::section heading="Dokumen PDF" class="surat-pdf-card">
                <div class="surat-pdf-content">
                    @if($record->file_pdf && \Illuminate\Support\Facades\Storage::disk('public')->exists($record->file_pdf))
                        <div class="surat-pdf-frame">
                            <iframe
                                src="{{ \Illuminate\Support\Facades\Storage::url($record->file_pdf) }}#toolbar=0&navpanes=0&scrollbar=1"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                            ></iframe>
                        </div>
                    @else
                        <div class="surat-pdf-empty">
                            <svg style="width: 3rem; height: 3rem; color: #d1d5db; margin-bottom: 0.75rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p style="font-size: 0.875rem; font-weight: 500; color: #4b5563;">Dokumen PDF tidak tersedia</p>
                            <p style="font-size: 0.75rem; color: #9ca3af; margin-top: 0.25rem;">File belum di-generate atau telah dihapus.</p>
                        </div>
                    @endif
                </div>
            </x-filament::section>
        </div>

    </div>
</x-filament-panels::page>

<style>
    /* ======================================================
       SCOPED CSS — hanya berlaku dalam .surat-detail-wrapper
       Tidak ada selector global yang menyentuh Filament lain
    ====================================================== */

    /* Label & Value teks */
    .surat-detail-wrapper .surat-label {
        font-size: 0.65rem;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.1rem;
    }
    .surat-detail-wrapper .surat-value {
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827;
    }

    /* Data Form internal scroll */
    .surat-detail-wrapper .surat-data-scroll {
        max-height: calc(100vh - 25rem);
        min-height: 150px;
        overflow-y: auto;
        padding-right: 0.5rem;
    }
    .surat-detail-wrapper .surat-data-scroll::-webkit-scrollbar { width: 4px; }
    .surat-detail-wrapper .surat-data-scroll::-webkit-scrollbar-track { background: transparent; }
    .surat-detail-wrapper .surat-data-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }

    /* PDF card harus mengambil seluruh tinggi kolom kanan */
    .surat-detail-wrapper .surat-pdf-card {
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    /* Memaksa wrapper internal Filament Section untuk merenggang (stretch) */
    .surat-detail-wrapper .surat-pdf-card > div {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .surat-detail-wrapper .surat-pdf-card .fi-section-content {
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .surat-detail-wrapper .surat-pdf-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 0; /* Important for flex children to shrink/grow properly */
    }
    .surat-detail-wrapper .surat-pdf-frame {
        flex: 1;
        width: 100%;
        height: 100%;
        min-height: 500px; /* Base fallback height */
        background: #e5e7eb;
        border-radius: 0.375rem;
        overflow: hidden;
        border: 1px solid #d1d5db;
        position: relative; /* Key fix for iframe height 100% bug */
    }
    .surat-detail-wrapper .surat-pdf-empty {
        flex: 1;
        min-height: 400px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: #f9fafb;
        border-radius: 0.375rem;
        border: 1px dashed #d1d5db;
    }

    /* =====================
       LAYOUT UTAMA (Grid)
    ===================== */

    /* Mobile: single column */
    .surat-detail-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .surat-col-kiri {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .surat-col-kanan {
        display: flex;
        flex-direction: column;
        min-height: 600px;
    }

    /* Desktop >= 1024px: 2 kolom 30% / 70% */
    @media (min-width: 1024px) {
        .surat-detail-wrapper {
            display: grid;
            grid-template-columns: minmax(280px, 30%) 1fr;
            grid-template-rows: 1fr;
            gap: 1.5rem;
            align-items: stretch; /* Kunci agar kedua kolom tingginya sama */
            min-height: calc(100vh - 12rem); /* Dynamic viewport height minus header */
        }
        .surat-col-kiri {
            grid-column: 1;
            grid-row: 1;
        }
        .surat-col-kanan {
            grid-column: 2;
            grid-row: 1;
            height: auto;
            min-height: 0;
        }
    }
</style>
