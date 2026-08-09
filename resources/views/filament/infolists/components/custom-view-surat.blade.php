@php
    $record = $getRecord();
@endphp
<div class="custom-surat-grid">
    <!-- Kolom Kiri -->
    <div class="custom-surat-kiri">
        <!-- Card Informasi -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-5">
            <h3 class="text-base font-semibold leading-6 text-gray-950 mb-4 border-b border-gray-100 pb-3">Informasi Arsip</h3>
            
            <div class="flex flex-col gap-4">
                <div>
                    <span class="text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider block mb-1">Nomor Surat</span>
                    <span class="text-sm font-bold text-gray-900 block">{{ $record->nomor_surat }}</span>
                </div>
                
                <div>
                    <span class="text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider block mb-1">Jenis Surat</span>
                    <span class="inline-flex items-center rounded-md bg-primary-50 px-2 py-1 text-xs font-medium text-primary-700 ring-1 ring-inset ring-primary-600/20">{{ $record->jenisSurat->nama_surat ?? '-' }}</span>
                </div>

                <div>
                    <span class="text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider block mb-1">Nama Pemohon</span>
                    <span class="text-sm font-medium text-gray-800 block">{{ $record->nama_pemohon }}</span>
                </div>

                <div>
                    <span class="text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider block mb-1">Dibuat Pada</span>
                    <span class="text-sm font-medium text-gray-800 block">{{ $record->created_at->translatedFormat('d M Y, H:i') }}</span>
                </div>

                <div>
                    <span class="text-[0.7rem] font-bold text-gray-500 uppercase tracking-wider block mb-1">Status Scan</span>
                    @php
                        $statusColor = match($record->status_scan) {
                            'belum_upload' => 'bg-warning-50 text-warning-700 ring-warning-600/20',
                            'sudah_upload' => 'bg-success-50 text-success-700 ring-success-600/20',
                            default => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                        };
                    @endphp
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusColor }}">
                        {{ str_replace('_', ' ', $record->status_scan) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Card Data Form -->
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 p-5 mt-6">
            <h3 class="text-base font-semibold leading-6 text-gray-950 mb-4 border-b border-gray-100 pb-3">Data Form</h3>
            @php
                $dataJson = is_string($record->data_json) ? json_decode($record->data_json, true) : $record->data_json;
            @endphp
            @if(is_array($dataJson) && count($dataJson) > 0)
                <div class="max-h-[350px] overflow-y-auto pr-2 custom-scroll">
                    <div class="flex flex-col gap-3">
                        @foreach($dataJson as $key => $value)
                            <div class="pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                                <span class="text-[0.65rem] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">{{ \Illuminate\Support\Str::headline($key) }}</span>
                                <span class="text-sm font-medium text-gray-800 block">{{ $value ?: '-' }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-sm text-gray-500 italic">Tidak ada data form.</p>
            @endif
        </div>
    </div>

    <!-- Kolom Kanan (PDF) -->
    <div class="custom-surat-kanan">
        <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5 overflow-hidden flex flex-col w-full h-full">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="text-base font-semibold leading-6 text-gray-950">Dokumen PDF</h3>
            </div>
            
            <!-- PDF Viewer Area -->
            <div class="flex-1 w-full bg-gray-200/50 p-4 lg:p-6 flex justify-center items-start overflow-hidden relative">
                @if($record->file_pdf && \Illuminate\Support\Facades\Storage::disk('public')->exists($record->file_pdf))
                    <div class="w-full shadow-lg bg-white relative" style="height: calc(100vh - 220px); min-height: 650px;">
                        <iframe
                            src="{{ \Illuminate\Support\Facades\Storage::url($record->file_pdf) }}#toolbar=0&navpanes=0&scrollbar=1"
                            class="absolute inset-0 w-full h-full border-0"
                            style="width: 100%; height: 100%;"
                        ></iframe>
                    </div>
                @else
                    <div class="m-auto text-center p-8 bg-white/80 rounded-xl border border-dashed border-gray-300 shadow-sm w-full max-w-md" style="min-height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="text-base font-medium text-gray-900">Dokumen PDF tidak tersedia</p>
                        <p class="text-sm text-gray-500 mt-1">File mungkin belum di-generate atau telah dihapus.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .custom-surat-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    @media (min-width: 1024px) {
        .custom-surat-grid {
            grid-template-columns: 32% 68%;
            /* atau minmax(300px, 0.32fr) minmax(600px, 0.68fr) */
            grid-template-columns: minmax(280px, 0.32fr) minmax(600px, 0.68fr);
        }
    }

    .custom-surat-kiri {
        display: flex;
        flex-direction: column;
    }

    .custom-surat-kanan {
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: transparent; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 4px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #9ca3af; }
</style>
