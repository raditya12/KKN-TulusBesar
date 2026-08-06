<x-filament-panels::page>
    <div
        x-data="{
            zoom: 100,
            fitWidth: false,
            isFullscreen: false,
            zoomIn() { if (this.zoom < 150) this.zoom += 10; this.fitWidth = false; },
            zoomOut() { if (this.zoom > 50) this.zoom -= 10; this.fitWidth = false; },
            resetZoom() { this.zoom = 100; this.fitWidth = false; },
            toggleFitWidth() { this.fitWidth = !this.fitWidth; if(this.fitWidth) this.zoom = 100; },
            toggleFullscreen() { this.isFullscreen = !this.isFullscreen; }
        }"
        class="space-y-6"
    >
        <style>
            /* Modern MS Word A4 Paper Canvas */
            .a4-paper-canvas {
                background: #ffffff;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 0 0 1px rgba(0, 0, 0, 0.05);
                border-radius: 4px;
                width: 100%;
                max-width: 794px;
                min-height: 1123px;
                margin: 0 auto 2rem;
                padding: 48px 56px;
                font-family: 'Times New Roman', Times, serif;
                font-size: 11.5pt;
                line-height: 1.6;
                color: #111827;
                transition: transform 0.2s ease, max-width 0.2s ease;
                box-sizing: border-box;
            }
            .a4-paper-canvas table {
                width: 100%;
                border-collapse: collapse;
            }
            .a4-paper-canvas td {
                padding: 3px 6px;
                vertical-align: top;
            }
            .custom-form-input {
                width: 100%;
                padding: 8px 12px;
                font-size: 0.875rem;
                border-radius: 0.5rem;
                border: 1px solid rgba(140, 90, 53, 0.3);
                background-color: #ffffff;
                color: #111827;
                transition: border-color 0.15s ease, box-shadow 0.15s ease;
            }
            .dark .custom-form-input {
                background-color: #1e140f;
                border-color: rgba(140, 90, 53, 0.5);
                color: #f9fafb;
            }
            .custom-form-input:focus {
                outline: none;
                border-color: #8C5A35;
                box-shadow: 0 0 0 3px rgba(140, 90, 53, 0.15);
            }

            /* Custom Table Styling for Riwayat Surat */
            .custom-riwayat-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                font-size: 0.8125rem;
            }
            .custom-riwayat-table th {
                padding: 10px 16px !important;
                text-align: left !important;
                font-size: 0.75rem !important;
                font-weight: 700 !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                background-color: rgba(140, 90, 53, 0.08) !important;
                color: #4a2b1d !important;
                border-bottom: 2px solid rgba(140, 90, 53, 0.2) !important;
            }
            .dark .custom-riwayat-table th {
                background-color: rgba(140, 90, 53, 0.25) !important;
                color: #f3f4f6 !important;
                border-bottom: 2px solid rgba(140, 90, 53, 0.4) !important;
            }
            .custom-riwayat-table td {
                padding: 12px 16px !important;
                border-bottom: 1px solid rgba(140, 90, 53, 0.1) !important;
                vertical-align: middle !important;
            }
            .dark .custom-riwayat-table td {
                border-bottom: 1px solid rgba(140, 90, 53, 0.2) !important;
            }
            .custom-riwayat-table tr:hover td {
                background-color: rgba(140, 90, 53, 0.04) !important;
            }
        </style>

        {{-- WORKSPACE 2-COLUMN LAYOUT --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

            {{-- KOLOM KIRI: Form Input --}}
            <div class="lg:col-span-5 space-y-4">
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-pencil-square" class="w-5 h-5 text-primary-600" />
                            <span class="font-bold">Data Permohonan Surat</span>
                        </div>
                    </x-slot>

                    <div class="space-y-4">
                        {{-- Step 1: Pilih Jenis Surat --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Pilih Jenis Surat</label>
                            <select
                                wire:model.live="jenis_surat_id"
                                class="custom-form-input font-semibold text-sm"
                            >
                                <option value="0">— Pilih Jenis Surat —</option>
                                @foreach($jenisSuratOptions as $id => $nama)
                                    <option value="{{ $id }}">{{ $nama }}</option>
                                @endforeach
                                <option value="custom">✏️ Custom Surat (Buat Sendiri)</option>
                            </select>
                        </div>

                        {{-- Step 2: Dynamic Input Fields / Isian Field Surat --}}
                        @if(count($dynamicFields) > 0)
                            <div class="space-y-3 bg-amber-50/40 dark:bg-gray-800/60 p-4 rounded-xl border border-amber-200/60 dark:border-gray-700/60 max-h-[480px] overflow-y-auto pr-2">
                                <div class="flex items-center justify-between pb-2 border-b border-amber-200/40 dark:border-gray-700/60">
                                    <span class="text-xs font-bold text-amber-900 dark:text-amber-300 tracking-wider uppercase">
                                        📋 Isian Kolom Surat ({{ count($dynamicFields) }} Kolom)
                                    </span>
                                </div>

                                @foreach($dynamicFields as $field)
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                            {{ $field['label'] }}
                                        </label>

                                        @if(str_contains(strtolower($field['key']), 'alamat') || str_contains(strtolower($field['key']), 'keperluan') || str_contains(strtolower($field['key']), 'deskripsi'))
                                            <textarea
                                                wire:model.live.debounce.300ms="fieldValues.{{ $field['key'] }}"
                                                rows="2"
                                                placeholder="Tulis {{ strtolower($field['label']) }}..."
                                                class="custom-form-input resize-none"
                                            ></textarea>
                                        @else
                                            <input
                                                type="text"
                                                wire:model.live.debounce.300ms="fieldValues.{{ $field['key'] }}"
                                                placeholder="Tulis {{ strtolower($field['label']) }}..."
                                                class="custom-form-input"
                                            />
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            @if(! $isCustom)
                                <div class="p-4 text-center bg-gray-50 dark:bg-gray-800/40 border border-gray-200 dark:border-gray-700/60 rounded-xl text-xs italic text-gray-400 dark:text-gray-500">
                                    Pilih jenis surat di atas untuk memuat kolom isian otomatis.
                                </div>
                            @endif
                        @endif

                        {{-- Nomor & Tanggal Surat --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Surat</label>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="nomor_surat"
                                    placeholder="451.1 / 023 / DS / 08 / 2026"
                                    class="custom-form-input font-mono text-xs"
                                />
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Surat</label>
                                <input
                                    type="date"
                                    wire:model.live="tanggal_surat"
                                    class="custom-form-input text-xs"
                                />
                            </div>
                        </div>

                        {{-- Konten Custom --}}
                        @if($isCustom)
                            <div class="space-y-3 border-t border-gray-100 dark:border-gray-800 pt-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Surat Custom</label>
                                    <input
                                        type="text"
                                        wire:model.live.debounce.300ms="namaSuratCustom"
                                        placeholder="Surat Keterangan..."
                                        class="custom-form-input font-medium"
                                    />
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Isi Surat</label>
                                    <textarea
                                        wire:model.live.debounce.300ms="kontenCustom"
                                        rows="5"
                                        placeholder="Ketik isi surat..."
                                        class="custom-form-input font-mono text-xs"
                                    ></textarea>
                                </div>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="space-y-2 pt-3 border-t border-gray-100 dark:border-gray-800">
                            <x-filament::button
                                wire:click="generateSurat"
                                wire:loading.attr="disabled"
                                icon="heroicon-o-arrow-down-tray"
                                class="w-full justify-center font-bold py-2.5 shadow-sm"
                            >
                                Generate & Simpan Surat
                            </x-filament::button>

                            <x-filament::button
                                wire:click="downloadPdf"
                                wire:loading.attr="disabled"
                                color="gray"
                                outlined
                                icon="heroicon-o-printer"
                                class="w-full justify-center font-semibold"
                            >
                                Unduh PDF / Cetak
                            </x-filament::button>
                        </div>
                    </div>
                </x-filament::section>
            </div>

            {{-- KOLOM KANAN: Preview A4 Canvas --}}
            <div
                class="lg:col-span-7"
                :class="{ 'fixed inset-0 z-50 p-6 bg-gray-900 overflow-y-auto': isFullscreen }"
            >
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-eye" class="w-5 h-5 text-primary-600" />
                            <span class="font-bold">Pratinjau Lembar Surat (A4)</span>
                        </div>
                    </x-slot>

                    <x-slot name="headerEnd">
                        <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg border border-gray-200 dark:border-gray-700 text-xs">
                            <button type="button" @click="zoomOut()" class="p-1.5 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300" title="Zoom Out">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                            </button>
                            <button type="button" @click="resetZoom()" class="px-2 py-0.5 text-[11px] font-mono font-bold text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-700 rounded" title="Reset Zoom">
                                <span x-text="zoom + '%'">100%</span>
                            </button>
                            <button type="button" @click="zoomIn()" class="p-1.5 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300" title="Zoom In">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                            </button>
                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" @click="toggleFitWidth()" :class="{ 'bg-primary-600 text-white': fitWidth, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !fitWidth }" class="px-2 py-0.5 text-[11px] font-medium rounded transition" title="Fit Width">
                                Fit
                            </button>
                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>
                            <button type="button" @click="toggleFullscreen()" :class="{ 'bg-primary-600 text-white': isFullscreen, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !isFullscreen }" class="p-1.5 rounded transition" title="Fullscreen">
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </button>
                        </div>
                    </x-slot>

                    {{-- Scrollable Preview Canvas --}}
                    <div class="bg-gray-200/80 dark:bg-gray-950 rounded-xl overflow-auto border border-gray-300/60 dark:border-gray-800 p-6 min-h-[600px] max-h-[calc(100vh-12rem)] flex justify-center">
                        <div
                            class="a4-paper-canvas"
                            :style="{
                                transform: 'scale(' + (zoom / 100) + ')',
                                transformOrigin: 'top center',
                                maxWidth: fitWidth ? '100%' : '794px'
                            }"
                        >
                            @if($previewHtml)
                                {!! $previewHtml !!}
                            @else
                                {{-- Kop Surat Default --}}
                                <table style="width: 100%; border-bottom: 3px double #000; margin-bottom: 16px; padding-bottom: 8px; border-collapse: collapse;">
                                    <tr>
                                        <td style="width: 90px; vertical-align: middle; text-align: center; padding-right: 10px;">
                                            <img src="/images/logo-malang.png" alt="Logo Kabupaten Malang" style="width: 80px; height: 80px; object-fit: contain;" />
                                        </td>
                                        <td style="vertical-align: middle; text-align: center; line-height: 1.3;">
                                            <p style="font-size: 12pt; font-weight: normal; margin: 0; text-transform: uppercase;">PEMERINTAH KABUPATEN {{ strtoupper($namaKabupaten) }}</p>
                                            <p style="font-size: 12pt; font-weight: normal; margin: 0; text-transform: uppercase;">KECAMATAN {{ strtoupper($namaKecamatan) }}</p>
                                            <p style="font-size: 16pt; font-weight: bold; margin: 2px 0; text-transform: uppercase;">DESA {{ strtoupper($namaDesa) }}</p>
                                            <p style="font-size: 9pt; margin: 0;">Jalan Raya Tulusbesar No. 012 RT.04 RW.01, Kabupaten Malang, Jawa Timur</p>
                                            <p style="font-size: 9pt; margin: 0;">Telpon 0813-3311-4564 Laman : malangtulusbesar.desa.kemendesa.go.id</p>
                                            <p style="font-size: 9pt; margin: 0; text-decoration: underline;">Pos-el: email:pemdes.tulusbesar2018@gmail.com, Kode Pos : 65156</p>
                                        </td>
                                    </tr>
                                </table>

                                <div style="text-align: center; margin: 80px 0;">
                                    <p style="font-weight: bold; font-size: 13pt; text-transform: uppercase; color: #9ca3af;">
                                        PILIH JENIS SURAT DI SAMPING UNTUK MEMUAT TEMPLATE & PRATINJAU LANGSUNG
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-filament::section>
            </div>

        </div>

        {{-- BAGIAN BAWAH: RIWAYAT SURAT TERBARU --}}
        <x-filament::section class="mt-6">
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-clock" class="w-4 h-4 text-primary-600" />
                    <span>Riwayat Surat Terbaru</span>
                </div>
            </x-slot>

            <x-slot name="headerEnd">
                <a href="{{ \App\Filament\Resources\Surat\SuratResource::getUrl('index') }}" class="text-xs font-semibold text-primary-600 hover:underline">
                    Lihat Semua Arsip &rarr;
                </a>
            </x-slot>

            <div class="overflow-x-auto">
                <table class="custom-riwayat-table">
                    <thead>
                        <tr>
                            <th>Nomor Surat</th>
                            <th>Jenis Surat</th>
                            <th>Nama Warga</th>
                            <th>NIK</th>
                            <th>Tanggal Surat</th>
                            <th style="text-align: right !important;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayatSurat as $surat)
                            <tr>
                                <td class="font-mono font-semibold text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</td>
                                <td>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700 dark:bg-primary-950 dark:text-primary-300 border border-primary-200 dark:border-primary-800">
                                        {{ $surat->jenisSurat->nama ?? 'Custom' }}
                                    </span>
                                </td>
                                <td class="font-medium text-gray-900 dark:text-white">{{ $surat->nama_warga }}</td>
                                <td class="font-mono text-gray-500">{{ $surat->nik ?? '-' }}</td>
                                <td>{{ $surat->tanggal_surat ? $surat->tanggal_surat->format('d M Y') : '-' }}</td>
                                <td style="text-align: right !important;">
                                    @if($surat->pdf_generated_path)
                                        <a
                                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($surat->pdf_generated_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-primary-50 hover:bg-primary-100 dark:bg-primary-950 dark:hover:bg-primary-900 text-primary-700 dark:text-primary-300 rounded-md font-medium transition"
                                        >
                                            <x-filament::icon icon="heroicon-o-arrow-down-tray" class="w-3.5 h-3.5" />
                                            <span>PDF</span>
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Draft</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-gray-400 italic">
                                    Belum ada riwayat pembuatan surat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-filament::section>

    </div>
</x-filament-panels::page>
