<x-filament-panels::page>
    <style>
        /* Modern MS Word A4 Paper Canvas */
        .a4-paper-canvas {
            background: #ffffff;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            border-radius: 2px;
            width: 100%;
            max-width: 794px;
            margin: 0 auto;
            padding: 48px 56px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.6;
            color: #111827;
            min-height: 1050px;
            transition: transform 0.2s ease, max-width 0.2s ease;
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
            padding: 7px 10px;
            font-size: 0.8125rem;
            border-radius: 0.5rem;
            border: 1px solid rgba(140, 90, 53, 0.25);
            background-color: #ffffff;
            color: #111827;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
        }
        .dark .custom-form-input {
            background-color: #1e140f;
            border-color: rgba(140, 90, 53, 0.4);
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
        {{-- WORKSPACE 12-COLUMN GRID LAYOUT --}}
        <div class="grid grid-cols-12 gap-6 items-start">

            {{-- KOLOM KIRI (SPAN 4): STICKY FORM CARDS --}}
            <div class="col-span-12 lg:col-span-4 space-y-4 lg:sticky lg:top-4 lg:max-h-[calc(100vh-2rem)] lg:overflow-y-auto pr-1">

                {{-- 1. Card: Jenis Surat --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-document-text" class="w-4 h-4 text-primary-600" />
                            <span>1. Jenis Surat</span>
                        </div>
                    </x-slot>

                    <div>
                        <select
                            wire:model.live="jenis_surat_id"
                            class="custom-form-input font-medium"
                        >
                            <option value="0">— Pilih Jenis Surat —</option>
                            @foreach($jenisSuratOptions as $id => $nama)
                                <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                            <option value="custom">✏️ Custom Surat (Buat Sendiri)</option>
                        </select>
                    </div>
                </x-filament::section>

                {{-- 2. Card: Data Warga & Placeholder Template --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-user" class="w-4 h-4 text-primary-600" />
                            <span>2. Form Input Template (Dinamis)</span>
                        </div>
                    </x-slot>

                    <div class="space-y-3">
                        {{-- Cari NIK Input --}}
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Cari NIK Warga</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="searchNik"
                                placeholder="Masukkan NIK Warga..."
                                class="custom-form-input font-mono"
                            />
                        </div>

                        {{-- Dynamic Placeholder Fields --}}
                        <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 space-y-2.5">
                            @forelse($dynamicFields as $field)
                                <div>
                                    <label class="block text-[11px] font-semibold text-gray-700 dark:text-gray-300 mb-0.5">
                                        {{ $field['label'] }}
                                        <span class="text-xs text-amber-600 dark:text-amber-400 font-mono">({{ $field['placeholder_raw'] }})</span>
                                    </label>

                                    @if(str_contains(strtolower($field['key']), 'alamat') || str_contains(strtolower($field['key']), 'keperluan') || str_contains(strtolower($field['key']), 'deskripsi'))
                                        <textarea
                                            wire:model.live.debounce.300ms="fieldValues.{{ $field['key'] }}"
                                            rows="2"
                                            placeholder="Isi {{ $field['label'] }}..."
                                            class="custom-form-input resize-none"
                                        ></textarea>
                                    @else
                                        <input
                                            type="text"
                                            wire:model.live.debounce.300ms="fieldValues.{{ $field['key'] }}"
                                            placeholder="Isi {{ $field['label'] }}..."
                                            class="custom-form-input"
                                        />
                                    @endif
                                </div>
                            @empty
                                @if(! $isCustom)
                                    <p class="text-xs text-gray-400 dark:text-gray-500 italic text-center py-2">
                                        Pilih jenis surat di atas untuk memuat field dinamis.
                                    </p>
                                @endif
                            @endforelse
                        </div>
                    </div>
                </x-filament::section>

                {{-- 3. Panel: Placeholder Tambahan (Opsional) --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-plus-circle" class="w-4 h-4 text-primary-600" />
                                <span>3. Placeholder Tambahan</span>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="headerEnd">
                        <x-filament::button
                            wire:click="openPlaceholderModal"
                            size="xs"
                            icon="heroicon-o-plus"
                            color="gray"
                        >
                            Tambah Field
                        </x-filament::button>
                    </x-slot>

                    <div class="space-y-2.5">
                        @forelse($extraPlaceholders as $extra)
                            <div class="p-2.5 rounded-lg bg-indigo-50/70 dark:bg-indigo-950/40 border border-indigo-200 dark:border-indigo-800 space-y-1">
                                <div class="flex items-center justify-between">
                                    <label class="text-[11px] font-semibold text-indigo-900 dark:text-indigo-200">
                                        {{ $extra['label'] }}
                                        <span class="font-mono text-[10px] text-indigo-600 dark:text-indigo-400">({{ $extra['placeholder_raw'] }})</span>
                                    </label>
                                    <button
                                        type="button"
                                        wire:click="removeExtraPlaceholder('{{ $extra['key'] }}')"
                                        class="text-xs text-red-500 hover:text-red-700 font-bold px-1.5 py-0.5 rounded hover:bg-red-50 dark:hover:bg-red-950"
                                        title="Hapus field ini"
                                    >
                                        &times;
                                    </button>
                                </div>
                                <input
                                    type="text"
                                    wire:model.live.debounce.300ms="fieldValues.{{ $extra['key'] }}"
                                    placeholder="Isi {{ $extra['label'] }}..."
                                    class="custom-form-input"
                                />
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 dark:text-gray-500 italic text-center py-1.5">
                                Belum ada placeholder tambahan. Klik "+ Tambah Field" jika memerlukan field opsional (RT, RW, No. KK, dll.).
                            </p>
                        @endforelse
                    </div>
                </x-filament::section>

                {{-- 4. Card: Nomor & Tanggal Surat --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-hashtag" class="w-4 h-4 text-primary-600" />
                            <span>4. Nomor & Tanggal Surat</span>
                        </div>
                    </x-slot>

                    <div class="space-y-2.5">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Nomor Surat</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="nomor_surat"
                                placeholder="451.1 / 023 / DS / X / 2026"
                                class="custom-form-input font-mono"
                            />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Tanggal Surat</label>
                            <input
                                type="date"
                                wire:model.live="tanggal_surat"
                                class="custom-form-input"
                            />
                        </div>
                    </div>
                </x-filament::section>

                {{-- Custom Content Card (If Custom Mode) --}}
                @if($isCustom)
                    <x-filament::section>
                        <x-slot name="heading">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-pencil" class="w-4 h-4 text-primary-600" />
                                <span>✏️ Konten Custom</span>
                            </div>
                        </x-slot>
                        <textarea
                            wire:model.live.debounce.300ms="kontenCustom"
                            rows="5"
                            placeholder="Ketik isi surat custom di sini..."
                            class="custom-form-input font-mono text-xs"
                        ></textarea>
                    </x-filament::section>
                @endif

                {{-- 5. Card: Action --}}
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-cog-6-tooth" class="w-4 h-4 text-primary-600" />
                            <span>5. Aksi</span>
                        </div>
                    </x-slot>

                    <div class="space-y-2">
                        <x-filament::button
                            wire:click="generateSurat"
                            wire:loading.attr="disabled"
                            icon="heroicon-o-arrow-down-tray"
                            class="w-full"
                        >
                            Generate PDF & Simpan
                        </x-filament::button>

                        <x-filament::button
                            wire:click="downloadPdf"
                            wire:loading.attr="disabled"
                            color="gray"
                            icon="heroicon-o-printer"
                            class="w-full"
                        >
                            Print / Unduh Dokumen
                        </x-filament::button>
                    </div>
                </x-filament::section>

            </div>

            {{-- KOLOM KANAN (SPAN 8): HTML PREVIEW VIEWER --}}
            <div
                class="col-span-12 lg:col-span-8"
                :class="{ 'fixed inset-0 z-50 p-6 bg-gray-900 overflow-y-auto': isFullscreen }"
            >
                <x-filament::section>
                    <x-slot name="heading">
                        <div class="flex items-center justify-between w-full">
                            <div class="flex items-center gap-2">
                                <x-filament::icon icon="heroicon-o-eye" class="w-4 h-4 text-primary-600" />
                                <span>Pratinjau Surat (Viewer)</span>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="headerEnd">
                        {{-- Toolbar Controls --}}
                        <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg border border-gray-200 dark:border-gray-700 text-xs">
                            <button
                                type="button"
                                @click="zoomOut()"
                                class="p-1 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300"
                                title="Zoom Out (-10%)"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></svg>
                            </button>

                            <button
                                type="button"
                                @click="resetZoom()"
                                class="px-2 py-0.5 text-[11px] font-mono font-medium text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-700 rounded"
                                title="Reset Zoom (100%)"
                            >
                                <span x-text="zoom + '%'">100%</span>
                            </button>

                            <button
                                type="button"
                                @click="zoomIn()"
                                class="p-1 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300"
                                title="Zoom In (+10%)"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></svg>
                            </button>

                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>

                            <button
                                type="button"
                                @click="toggleFitWidth()"
                                :class="{ 'bg-primary-600 text-white': fitWidth, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !fitWidth }"
                                class="px-2 py-0.5 text-[11px] font-medium rounded transition"
                                title="Fit Width"
                            >
                                Fit Width
                            </button>

                            <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>

                            <button
                                type="button"
                                @click="toggleFullscreen()"
                                :class="{ 'bg-primary-600 text-white': isFullscreen, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !isFullscreen }"
                                class="p-1 rounded transition"
                                title="Toggle Fullscreen"
                            >
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                            </button>
                        </div>
                    </x-slot>

                    {{-- HTML Viewer Container --}}
                    <div class="bg-gray-200 dark:bg-gray-950 p-6 rounded-xl overflow-x-auto min-h-[850px] flex justify-center items-start border border-gray-200 dark:border-gray-800">
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
                                <div style="text-align: center; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 3px double #000;">
                                    <p style="font-weight: bold; font-size: 13pt; text-transform: uppercase; margin: 0; line-height: 1.2;">
                                        PEMERINTAH KABUPATEN {{ strtoupper($namaKabupaten) }}
                                    </p>
                                    <p style="font-weight: bold; font-size: 12pt; text-transform: uppercase; margin: 2px 0; line-height: 1.2;">
                                        KECAMATAN {{ strtoupper($namaKecamatan) }}
                                    </p>
                                    <p style="font-weight: bold; font-size: 15pt; text-transform: uppercase; margin: 0; line-height: 1.2;">
                                        DESA {{ strtoupper($namaDesa) }}
                                    </p>
                                </div>

                                <div style="text-align: center; margin: 40px 0;">
                                    <p style="font-weight: bold; font-size: 13pt; text-transform: uppercase; color: #6b7280;">
                                        PILIH JENIS SURAT DI PANEL KIRI UNTUK MEMUAT TEMPLATE & PRATINJAU LIVE
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

        {{-- MODAL TAMBAH PLACEHOLDER --}}
        @if($showModalPlaceholder)
            <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl max-w-lg w-full p-5 space-y-4 shadow-2xl">
                    <div class="flex items-center justify-between pb-2 border-b border-gray-200 dark:border-gray-800">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <x-filament::icon icon="heroicon-o-plus-circle" class="w-5 h-5 text-primary-600" />
                            <span>Pilih Placeholder Tambahan</span>
                        </h3>
                        <button
                            type="button"
                            wire:click="closePlaceholderModal"
                            class="text-gray-400 hover:text-gray-600 font-bold text-lg"
                        >&times;</button>
                    </div>

                    {{-- Search Input inside Modal --}}
                    <div>
                        <input
                            type="text"
                            wire:model.live.debounce.200ms="modalSearch"
                            placeholder="Cari nama field / placeholder (cth: RT, RW, KK)..."
                            class="custom-form-input"
                        />
                    </div>

                    {{-- Placeholder List --}}
                    <div class="max-h-64 overflow-y-auto space-y-1.5 pr-1">
                        @forelse($masterPlaceholdersList as $mp)
                            <div class="flex items-center justify-between p-2.5 rounded-lg border border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                <div>
                                    <p class="text-xs font-semibold text-gray-900 dark:text-white">
                                        {{ $mp->nama_field }}
                                        <span class="font-mono text-[11px] text-amber-600 dark:text-amber-400 font-normal">({{ $mp->placeholder }})</span>
                                    </p>
                                    <p class="text-[10px] text-gray-400">{{ $mp->kategori }} — {{ $mp->deskripsi }}</p>
                                </div>
                                <x-filament::button
                                    wire:click="addExtraPlaceholder({{ $mp->id }})"
                                    size="xs"
                                >
                                    Pilih
                                </x-filament::button>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 italic text-center py-6">Tidak ada placeholder ditemukan.</p>
                        @endforelse
                    </div>

                    <div class="flex justify-end pt-2 border-t border-gray-100 dark:border-gray-800">
                        <x-filament::button
                            wire:click="closePlaceholderModal"
                            color="gray"
                            size="sm"
                        >
                            Tutup
                        </x-filament::button>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-filament-panels::page>
