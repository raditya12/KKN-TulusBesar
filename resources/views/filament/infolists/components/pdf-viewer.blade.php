@php
    $state = $getState();
@endphp

{{-- 
    Scoped CSS untuk layout halaman Lihat Arsip Surat.
    Selector #surat-detail-grid memastikan CSS ini HANYA menarget
    halaman ini dan tidak memengaruhi halaman Filament lainnya.
--}}
<style>
    /* Override grid Filament agar kolom kiri lebih sempit dan PDF lebih lebar */
    @media (min-width: 1024px) {
        #surat-detail-grid {
            grid-template-columns: 1fr 2fr !important;
            grid-template-rows: auto auto;
            align-items: start;
        }
        /* Informasi Arsip: kolom kiri, baris pertama */
        #surat-detail-grid > *:nth-child(1) {
            grid-column: 1;
            grid-row: 1;
        }
        /* Data Form: kolom kiri, baris kedua */
        #surat-detail-grid > *:nth-child(2) {
            grid-column: 1;
            grid-row: 2;
        }
        /* Dokumen PDF: kolom kanan, memanjang 2 baris */
        #surat-detail-grid > *:nth-child(3),
        .surat-pdf-section {
            grid-column: 2;
            grid-row: 1 / span 2;
        }
    }
</style>

@if($state && \Illuminate\Support\Facades\Storage::disk('public')->exists($state))
    <div style="width: 100%; min-width: 0; height: calc(100vh - 220px); min-height: 600px; border-radius: 0.375rem; overflow: hidden; border: 1px solid #d1d5db; background: #e5e7eb; display: flex; justify-content: center; align-items: center;">
        <iframe
            src="{{ \Illuminate\Support\Facades\Storage::url($state) }}#toolbar=0&navpanes=0&scrollbar=1"
            style="width: 100%; height: 100%; border: none;"
        ></iframe>
    </div>
@else
    <div style="padding: 3rem; text-align: center; color: #6b7280; background-color: #f9fafb; border-radius: 0.375rem; border: 1px dashed #d1d5db; display: flex; flex-direction: column; align-items: center; justify-content: center; height: calc(100vh - 220px); min-height: 600px; width: 100%;">
        <svg style="width: 3rem; height: 3rem; margin-bottom: 1rem; color: #9ca3af;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <p style="font-size: 1rem; font-weight: 500;">Dokumen PDF tidak tersedia.</p>
        <p style="font-size: 0.875rem; margin-top: 0.25rem;">File mungkin belum di-generate atau telah dihapus.</p>
    </div>
@endif
