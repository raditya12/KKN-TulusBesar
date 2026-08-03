<x-filament-panels::page>
    <style>
        /* Modern MS Word A4 Paper Styling */
        .word-workspace-bg {
            background-color: #e5e7eb;
            background-image: radial-gradient(#d1d5db 1px, transparent 1px);
            background-size: 16px 16px;
        }
        .dark .word-workspace-bg {
            background-color: #0f172a;
            background-image: radial-gradient(#1e293b 1px, transparent 1px);
        }
        .a4-paper {
            background: #ffffff;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1), 0 0 0 1px rgba(0, 0, 0, 0.05);
            border-radius: 2px;
            width: 100%;
            max-width: 794px; /* Standard A4 width pixel ratio */
            margin: 0 auto;
            padding: 48px 56px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 11.5pt;
            line-height: 1.6;
            color: #111827;
            min-height: 1050px; /* A4 aspect ratio height */
            transition: transform 0.2s ease, width 0.2s ease;
        }
        .a4-paper table {
            width: 100%;
            border-collapse: collapse;
        }
        .a4-paper td {
            padding: 3px 6px;
            vertical-align: top;
        }
        /* Custom Scrollbar for Left Panel */
        .left-panel-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .left-panel-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
        .left-panel-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .dark .left-panel-scroll::-webkit-scrollbar-thumb {
            background: #334155;
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
        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-2 border-b border-gray-200 dark:border-gray-800">
            <div>
                <h1 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white flex items-center gap-2">
                    <svg style="width: 22px; height: 22px;" class="text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Workspace Pembuatan Surat
                </h1>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                    Layanan pengarsipan dan pemprosesan cetak surat resmi desa.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Sistem Ready
                </span>
            </div>
        </div>

        {{-- WORKSPACE SPLIT LAYOUT --}}
        {{-- Desktop: 35% Left / 65% Right | Tablet: 40% Left / 60% Right | Mobile: Stacked --}}
        <div class="grid grid-cols-1 md:grid-cols-12 lg:grid-cols-12 gap-6 items-start">

            {{-- KIRI (35% Desktop / 40% Tablet / 100% Mobile): STICKY FORM PANEL --}}
            <div class="md:col-span-5 lg:col-span-4 space-y-4 md:sticky md:top-4 md:max-h-[calc(100vh-2rem)] md:overflow-y-auto left-panel-scroll pr-1">

                {{-- 1. Card Cari Data Warga --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                            <svg style="width: 15px; height: 15px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            1. Cari Data Warga
                        </h3>
                    </div>
                    <div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg style="width: 14px; height: 14px;" class="text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            </div>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="searchNik"
                                placeholder="Masukkan NIK Warga..."
                                class="w-full pl-9 pr-3 py-2 text-xs border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white font-mono focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>

                {{-- 2. Card Biodata Warga --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5 border-b border-gray-100 dark:border-gray-800 pb-2">
                        <svg style="width: 15px; height: 15px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        2. Biodata Warga
                    </h3>

                    <div class="bg-gray-50 dark:bg-gray-800/60 border border-gray-200/80 dark:border-gray-700 rounded-lg p-3 space-y-2.5">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Nama Lengkap</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="fieldValues.nama"
                                placeholder="Andi Wijaya"
                                class="w-full px-2.5 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">NIK</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="fieldValues.nik"
                                placeholder="3201234567890001"
                                class="w-full px-2.5 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white font-mono focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Tempat & Tanggal Lahir</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="fieldValues.tempat_tanggal_lahir"
                                placeholder="Nusantara, 15 Agustus 1985"
                                class="w-full px-2.5 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Alamat</label>
                            <textarea
                                wire:model.live.debounce.300ms="fieldValues.alamat"
                                rows="2"
                                placeholder="Jl. Desa No. 5, RT 02/RW 01, Dusun Mawar"
                                class="w-full px-2.5 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 resize-none"
                            ></textarea>
                        </div>
                    </div>
                </div>

                {{-- 3. Card Jenis Surat --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5 border-b border-gray-100 dark:border-gray-800 pb-2">
                        <svg style="width: 15px; height: 15px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        3. Jenis Surat
                    </h3>
                    <div class="relative">
                        <select
                            wire:model.live="jenis_surat_id"
                            class="w-full px-3 py-2 text-xs border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 pr-8 appearance-none"
                        >
                            <option value="0">— Pilih Jenis Surat —</option>
                            @foreach($jenisSuratOptions as $id => $nama)
                                <option value="{{ $id }}">{{ $nama }}</option>
                            @endforeach
                            <option value="custom">✏️ Custom Surat (Buat Sendiri)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2.5 text-gray-400">
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                {{-- 4. Card Nomor Surat & Tanggal --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5 border-b border-gray-100 dark:border-gray-800 pb-2">
                        <svg style="width: 15px; height: 15px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/></svg>
                        4. Nomor & Tanggal Surat
                    </h3>
                    <div class="space-y-2.5">
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Nomor Surat</label>
                            <input
                                type="text"
                                wire:model.live.debounce.300ms="nomor_surat"
                                placeholder="451.1 / 023 / DS / X / 2024"
                                class="w-full px-2.5 py-1.5 text-xs font-mono border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>
                        <div>
                            <label class="block text-[11px] font-semibold text-gray-600 dark:text-gray-400 mb-1">Tanggal Surat</label>
                            <input
                                type="date"
                                wire:model.live="tanggal_surat"
                                class="w-full px-2.5 py-1.5 text-xs border border-gray-300 dark:border-gray-700 rounded-md bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            />
                        </div>
                    </div>
                </div>

                {{-- 5. Card Keperluan --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5 border-b border-gray-100 dark:border-gray-800 pb-2">
                        <svg style="width: 15px; height: 15px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        5. Keperluan
                    </h3>
                    <div>
                        <textarea
                            wire:model.live.debounce.300ms="fieldValues.keperluan"
                            rows="3"
                            placeholder="Tuliskan keperluan pembuatan surat..."
                            class="w-full px-3 py-2 text-xs border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 resize-none"
                        ></textarea>
                    </div>
                </div>

                {{-- 6. Custom Surat Editor (If Custom) --}}
                @if($isCustom)
                    <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800 dark:text-gray-200 flex items-center gap-1.5 border-b border-gray-100 dark:border-gray-800 pb-2">
                            ✏️ 6. Konten Custom
                        </h3>
                        <textarea
                            wire:model.live.debounce.300ms="kontenCustom"
                            rows="6"
                            placeholder="Ketik isi surat custom di sini..."
                            class="w-full px-3 py-2 text-xs font-mono border border-gray-300 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                    </div>
                @endif

                {{-- 7 & 8. Action Buttons --}}
                <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-2.5">
                    <button
                        wire:click="generateSurat"
                        wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-xs rounded-lg shadow-sm transition duration-150"
                    >
                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        <span>7. Generate PDF & Simpan</span>
                    </button>

                    <button
                        wire:click="downloadPdf"
                        wire:loading.attr="disabled"
                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 border border-indigo-600 text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-950 font-medium text-xs rounded-lg transition duration-150"
                    >
                        <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>8. Print / Unduh Dokumen</span>
                    </button>
                </div>
            </div>

            {{-- KANAN (65% Desktop / 60% Tablet / 100% Mobile): PANEL PREVIEW SURAT --}}
            <div
                class="md:col-span-7 lg:col-span-8 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-4 shadow-sm space-y-4"
                :class="{ 'fixed inset-0 z-50 rounded-none border-none p-6 bg-gray-900 overflow-y-auto': isFullscreen }"
            >
                {{-- Toolbar Panel Top --}}
                <div class="flex flex-wrap items-center justify-between gap-3 pb-3 border-b border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 sticky top-0 z-10">
                    <div class="flex items-center gap-2">
                        <h2 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg style="width: 16px; height: 16px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            Pratinjau Surat
                        </h2>
                        <span class="text-[10px] text-gray-400 dark:text-gray-500 italic hidden sm:inline">(Realtime)</span>
                    </div>

                    {{-- Toolbar Controls --}}
                    <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 p-1 rounded-lg border border-gray-200 dark:border-gray-700 text-xs">
                        {{-- Zoom Out --}}
                        <button
                            type="button"
                            @click="zoomOut()"
                            class="p-1.5 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 transition"
                            title="Zoom Out (-10%)"
                        >
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"/></button>

                        {{-- Current Zoom percentage --}}
                        <button
                            type="button"
                            @click="resetZoom()"
                            class="px-2 py-0.5 text-[11px] font-mono font-medium text-gray-700 dark:text-gray-200 hover:bg-white dark:hover:bg-gray-700 rounded"
                            title="Reset Zoom (100%)"
                        >
                            <span x-text="zoom + '%'">100%</span>
                        </button>

                        {{-- Zoom In --}}
                        <button
                            type="button"
                            @click="zoomIn()"
                            class="p-1.5 rounded hover:bg-white dark:hover:bg-gray-700 text-gray-600 dark:text-gray-300 transition"
                            title="Zoom In (+10%)"
                        >
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"/></button>

                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>

                        {{-- Fit Width --}}
                        <button
                            type="button"
                            @click="toggleFitWidth()"
                            :class="{ 'bg-indigo-600 text-white': fitWidth, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !fitWidth }"
                            class="px-2 py-1 text-[11px] font-medium rounded transition"
                            title="Fit Width"
                        >
                            Fit Width
                        </button>

                        <div class="h-4 w-px bg-gray-300 dark:bg-gray-600 mx-1"></div>

                        {{-- Fullscreen --}}
                        <button
                            type="button"
                            @click="toggleFullscreen()"
                            :class="{ 'bg-indigo-600 text-white': isFullscreen, 'text-gray-600 dark:text-gray-300 hover:bg-white dark:hover:bg-gray-700': !isFullscreen }"
                            class="p-1.5 rounded transition"
                            title="Toggle Fullscreen"
                        >
                            <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                        </button>
                    </div>
                </div>

                {{-- MS WORD PREVIEW CONTAINER --}}
                <div class="word-workspace-bg p-6 rounded-xl overflow-x-auto min-h-[820px] flex justify-center items-start">
                    <div
                        class="a4-paper"
                        :style="{
                            transform: 'scale(' + (zoom / 100) + ')',
                            transformOrigin: 'top center',
                            maxWidth: fitWidth ? '100%' : '794px'
                        }"
                    >
                        @if($previewHtml)
                            {!! $previewHtml !!}
                        @else
                            {{-- Default Surat Keterangan Usaha Preview layout --}}
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

                            <div style="text-align: center; margin: 20px 0 16px;">
                                <p style="font-weight: bold; font-size: 13pt; text-decoration: underline; text-transform: uppercase; margin: 0;">
                                    SURAT KETERANGAN USAHA
                                </p>
                                <p style="font-size: 10.5pt; margin: 4px 0 0;">
                                    Nomor: {{ $nomor_surat ?? '451.1 / 023 / DS / X / 2024' }}
                                </p>
                            </div>

                            <div style="margin-bottom: 16px; text-align: justify;">
                                <p>
                                    Yang bertanda tangan di bawah ini, Kepala Desa {{ ucwords(strtolower($namaDesa)) }}, Kecamatan {{ ucwords(strtolower($namaKecamatan)) }}, Kabupaten {{ ucwords(strtolower($namaKabupaten)) }}, dengan ini menerangkan bahwa:
                                </p>
                            </div>

                            <table style="margin: 12px 0 16px 20px; width: 95%;">
                                <tr>
                                    <td style="width: 170px;">Nama Lengkap</td>
                                    <td style="width: 15px;">:</td>
                                    <td><strong>{{ !empty($fieldValues['nama']) ? $fieldValues['nama'] : 'Andi Wijaya' }}</strong></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['nik']) ? $fieldValues['nik'] : '3201234567890001' }}</td>
                                </tr>
                                <tr>
                                    <td>Tempat/Tgl Lahir</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['tempat_tanggal_lahir']) ? $fieldValues['tempat_tanggal_lahir'] : 'Nusantara, 15 Agustus 1985' }}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['jenis_kelamin']) ? $fieldValues['jenis_kelamin'] : 'Laki-laki' }}</td>
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['agama']) ? $fieldValues['agama'] : 'Islam' }}</td>
                                </tr>
                                <tr>
                                    <td>Pekerjaan</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['pekerjaan']) ? $fieldValues['pekerjaan'] : 'Wiraswasta' }}</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>{{ !empty($fieldValues['alamat']) ? $fieldValues['alamat'] : 'Jl. Desa No. 5, RT 02/RW 01, Dusun Mawar' }}</td>
                                </tr>
                            </table>

                            <p style="text-align: justify; margin-bottom: 12px;">
                                Berdasarkan surat pengantar dari RT/RW setempat serta sepengetahuan kami, nama tersebut di atas memang benar penduduk yang berdomisili di Desa {{ ucwords(strtolower($namaDesa)) }}, dan pada saat ini benar-benar memiliki usaha berupa:
                            </p>

                            <div style="background: #f3f4f6; border: 1px solid #e5e7eb; padding: 10px; text-align: center; font-weight: bold; margin: 12px 0 16px; border-radius: 4px; text-transform: uppercase;">
                                {{ !empty($fieldValues['keperluan']) ? $fieldValues['keperluan'] : 'TOKO KELONTONG **' }}
                            </div>

                            <p style="text-align: justify; margin-bottom: 24px;">
                                Demikian Surat Keterangan Usaha ini dibuat dengan sebenarnya untuk dapat dipergunakan sebagaimana mestinya. Kepada pihak yang berkepentingan diharap maklum.
                            </p>

                            <div style="float: right; text-align: center; width: 240px; margin-top: 20px;">
                                <p style="margin: 0;">{{ ucwords(strtolower($namaDesa)) }}, {{ \Carbon\Carbon::parse($tanggal_surat)->translatedFormat('d F Y') }}</p>
                                <p style="margin: 2px 0 60px;">Kepala Desa {{ ucwords(strtolower($namaDesa)) }}</p>
                                <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $namaKepalaDesa }}</p>
                                <p style="font-size: 10pt; margin: 2px 0;">NIP. {{ $nipKepalaDesa }}</p>
                            </div>
                            <div style="clear: both;"></div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- BAGIAN BAWAH: CARD RIWAYAT SURAT TERBARU --}}
        <div class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-xl p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-3">
                <h2 class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg style="width: 16px; height: 16px;" class="text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Riwayat Surat Terbaru
                </h2>
                <a href="{{ \App\Filament\Resources\Surat\SuratResource::getUrl('index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 dark:text-indigo-400">
                    Lihat Semua Arsip &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50 text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold border-b border-gray-200 dark:border-gray-700">
                            <th class="py-2.5 px-3">Nomor Surat</th>
                            <th class="py-2.5 px-3">Jenis Surat</th>
                            <th class="py-2.5 px-3">Nama Warga</th>
                            <th class="py-2.5 px-3">NIK</th>
                            <th class="py-2.5 px-3">Tanggal</th>
                            <th class="py-2.5 px-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800 text-gray-700 dark:text-gray-300">
                        @forelse($riwayatSurat as $surat)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-gray-800/40 transition">
                                <td class="py-2.5 px-3 font-mono font-medium text-gray-900 dark:text-white">{{ $surat->nomor_surat }}</td>
                                <td class="py-2.5 px-3">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300">
                                        {{ $surat->jenisSurat->nama ?? 'Custom' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 font-medium">{{ $surat->nama_warga }}</td>
                                <td class="py-2.5 px-3 font-mono text-gray-500">{{ $surat->nik ?? '-' }}</td>
                                <td class="py-2.5 px-3">{{ $surat->tanggal_surat ? $surat->tanggal_surat->format('d M Y') : '-' }}</td>
                                <td class="py-2.5 px-3 text-right space-x-2">
                                    @if($surat->pdf_generated_path)
                                        <a
                                            href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($surat->pdf_generated_path) }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 font-medium"
                                        >
                                            <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            PDF
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-400 italic">
                                    Belum ada riwayat pembuatan surat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-filament-panels::page>
