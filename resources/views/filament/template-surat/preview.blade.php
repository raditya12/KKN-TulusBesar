<x-filament-panels::page>
    @php
        $placeholderService = app(\App\Services\Surat\PlaceholderService::class);
        $placeholders = $placeholderService->extractPlaceholders($konten);
        $registeredPlaceholders = \App\Models\MasterPlaceholder::pluck('placeholder')->toArray();
        $validPlaceholders = array_intersect($placeholders, $registeredPlaceholders);
        $invalidPlaceholders = array_diff($placeholders, $registeredPlaceholders);

        // Comprehensive realistic sample resident data for simulation mode
        $sampleData = [
            'nama' => 'BAMBANG WIJAYA',
            'nik' => '3507121508850003',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => '15 Agustus 1985',
            'tempat_tanggal_lahir' => 'Malang, 15 Agustus 1985',
            'jenis_kelamin' => 'Laki-Laki',
            'agama' => 'Islam',
            'pekerjaan' => 'Wiraswasta',
            'status_perkawinan' => 'Kawin',
            'kewarganegaraan' => 'WNI',
            'alamat' => 'RT 04 RW 01 Dusun Krajan, Desa Tulusbesar, Kec. Tumpang, Kab. Malang',
            'nomor_surat' => '470 / 042 / 35.07.12.2004 / ' . date('Y'),
            'tanggal_surat' => \Carbon\Carbon::now()->translatedFormat('d F Y'),
            'keperluan' => 'Pengajuan Bantuan Modal Usaha Mikro (KUM)',
            'perihal' => 'Surat Keterangan Usaha',
            'nama_ayah' => 'Sutrisno',
            'nama_ibu' => 'Suparmi',
            'pekerjaan_ayah' => 'Petani',
            'penghasilan' => 'Rp 1.500.000,- / bulan',
            'nama_usaha' => 'Toko Kelontong Berkah Makmur',
            'jenis_usaha' => 'Perdagangan Sembako & Hasil Bumi',
            'alamat_usaha' => 'Jl. Raya Tulusbesar No. 45, Desa Tulusbesar',
            'nama_bayi' => 'Muhammad Rayyan Al-Fatih',
            'tanggal_lahir_bayi' => '01 Agustus ' . date('Y'),
            'nama_almarhum' => 'Alm. Soeprapto',
            'tanggal_meninggal' => '20 Juli ' . date('Y'),
            'barang_hilang' => '1 (Satu) Buah KTP Elektronik Asli',
            'nama_dokumen_lain' => 'Kartu Keluarga',
            'jenis_dokumen' => 'Dokumen Kependudukan',
            'nama_kepala_desa' => 'H. AHMAD FAUZI, S.AP.',
            'nip_kepala_desa' => '19750812 200212 1 004',
            'nama_anak' => 'Ananda Putri Pertiwi',
            'nik_anak' => '3507125204120002',
            'nama_sekolah' => 'SMK Negeri 1 Tumpang',
            'kelas_anak' => 'Kelas XI TKJ 2',
        ];

        // Replace for simulation view
        $simulatedHtml = $konten;
        foreach ($sampleData as $key => $val) {
            $simulatedHtml = str_replace('{{'.$key.'}}', '<strong>'.$val.'</strong>', $simulatedHtml);
        }

        // Highlight placeholders for variable mode
        $highlightedHtml = $konten;
        foreach ($placeholders as $ph) {
            $isValid = in_array($ph, $registeredPlaceholders);
            $badgeColor = $isValid 
                ? 'background-color: #e0e7ff; color: #3730a3; border: 1px solid #c7d2fe; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 11pt;' 
                : 'background-color: #ffe4e6; color: #9f1239; border: 1px solid #fecdd3; padding: 2px 6px; border-radius: 4px; font-family: monospace; font-size: 11pt;';
            $highlightedHtml = str_replace($ph, '<span style="'.$badgeColor.'" title="Variable Tag">'.$ph.'</span>', $highlightedHtml);
        }
    @endphp

    <div x-data="{ 
            viewMode: 'simulation', 
            zoom: 100, 
            showVars: true,
            copiedTag: null,
            copyTag(tag) {
                navigator.clipboard.writeText(tag);
                this.copiedTag = tag;
                setTimeout(() => { if (this.copiedTag === tag) this.copiedTag = null; }, 2000);
            }
         }" 
         class="ts-preview-wrapper">

        <!-- SCOPED DESIGN SYSTEM STYLES -->
        <style>
            .ts-preview-wrapper {
                display: flex;
                flex-direction: column;
                gap: 20px;
                width: 100%;
                max-width: 100%;
                font-family: inherit;
            }

            /* Glassmorphic & Modern Cards */
            .ts-card {
                background: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px 20px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 1px 2px rgba(0,0,0,0.03);
            }
            .dark .ts-card {
                background: #1e293b;
                border-color: #334155;
                color: #f8fafc;
            }

            /* Header Section */
            .ts-header-bar {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
                align-items: center;
                justify-content: space-between;
                gap: 16px;
            }
            .ts-header-info {
                display: flex;
                align-items: center;
                gap: 14px;
            }
            .ts-icon-box {
                width: 44px;
                height: 44px;
                border-radius: 10px;
                background: #eef2ff;
                color: #4f46e5;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .dark .ts-icon-box {
                background: rgba(79, 70, 229, 0.2);
                color: #818cf8;
            }
            .ts-title {
                font-size: 18px;
                font-weight: 700;
                color: #0f172a;
                margin: 0;
                display: flex;
                align-items: center;
                gap: 8px;
                flex-wrap: wrap;
            }
            .dark .ts-title {
                color: #f8fafc;
            }
            .ts-subtitle {
                font-size: 12.5px;
                color: #64748b;
                margin-top: 4px;
                display: flex;
                align-items: center;
                gap: 8px;
            }
            .dark .ts-subtitle {
                color: #94a3b8;
            }

            /* Badges */
            .ts-badge {
                display: inline-flex;
                align-items: center;
                padding: 3px 8px;
                border-radius: 6px;
                font-size: 11px;
                font-weight: 600;
                line-height: 1;
            }
            .ts-badge-success {
                background: #dcfce7;
                color: #15803d;
            }
            .dark .ts-badge-success {
                background: rgba(34, 197, 94, 0.2);
                color: #4ade80;
            }
            .ts-badge-muted {
                background: #f1f5f9;
                color: #64748b;
            }
            .dark .ts-badge-muted {
                background: #334155;
                color: #cbd5e1;
            }
            .ts-badge-primary {
                background: #e0e7ff;
                color: #4338ca;
            }
            .dark .ts-badge-primary {
                background: rgba(99, 102, 241, 0.2);
                color: #a5b4fc;
            }

            /* Button Controls */
            .ts-controls {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
            }
            .ts-segmented-group {
                display: inline-flex;
                background: #f1f5f9;
                padding: 3px;
                border-radius: 9px;
                border: 1px solid #e2e8f0;
            }
            .dark .ts-segmented-group {
                background: #0f172a;
                border-color: #334155;
            }
            .ts-segmented-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 6px 12px;
                border-radius: 7px;
                font-size: 12.5px;
                font-weight: 600;
                color: #64748b;
                background: transparent;
                border: none;
                cursor: pointer;
                transition: all 0.15s ease;
            }
            .dark .ts-segmented-btn {
                color: #94a3b8;
            }
            .ts-segmented-btn.active {
                background: #ffffff;
                color: #4f46e5;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            }
            .dark .ts-segmented-btn.active {
                background: #334155;
                color: #818cf8;
            }

            .ts-btn {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 7px 14px;
                border-radius: 8px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                text-decoration: none;
                transition: all 0.15s ease;
                border: 1px solid transparent;
            }
            .ts-btn-primary {
                background: #4f46e5;
                color: #ffffff;
            }
            .ts-btn-primary:hover {
                background: #4338ca;
                color: #ffffff;
            }
            .ts-btn-secondary {
                background: #ffffff;
                color: #334155;
                border-color: #cbd5e1;
            }
            .ts-btn-secondary:hover {
                background: #f8fafc;
                border-color: #94a3b8;
            }
            .dark .ts-btn-secondary {
                background: #1e293b;
                color: #e2e8f0;
                border-color: #475569;
            }
            .dark .ts-btn-secondary:hover {
                background: #334155;
            }

            .ts-zoom-group {
                display: inline-flex;
                align-items: center;
                background: #f1f5f9;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 2px 4px;
            }
            .dark .ts-zoom-group {
                background: #0f172a;
                border-color: #334155;
            }
            .ts-zoom-btn {
                background: transparent;
                border: none;
                color: #64748b;
                font-weight: bold;
                font-size: 14px;
                padding: 4px 8px;
                cursor: pointer;
                border-radius: 4px;
            }
            .ts-zoom-btn:hover {
                background: #e2e8f0;
                color: #0f172a;
            }
            .dark .ts-zoom-btn:hover {
                background: #334155;
                color: #f8fafc;
            }
            .ts-zoom-label {
                font-size: 11px;
                font-family: monospace;
                font-weight: 600;
                color: #475569;
                padding: 0 6px;
                min-width: 40px;
                text-align: center;
            }
            .dark .ts-zoom-label {
                color: #cbd5e1;
            }

            /* Variable Analysis Box */
            .ts-vars-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                cursor: pointer;
                user-select: none;
            }
            .ts-tag-chip {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                padding: 3px 8px;
                border-radius: 6px;
                font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
                font-size: 12px;
                cursor: pointer;
                transition: all 0.15s ease;
                border: 1px solid transparent;
            }
            .ts-tag-chip.valid {
                background: #f0fdf4;
                color: #166534;
                border-color: #bbf7d0;
            }
            .ts-tag-chip.valid:hover {
                background: #dcfce7;
                border-color: #86efac;
            }
            .dark .ts-tag-chip.valid {
                background: rgba(22, 101, 52, 0.2);
                color: #86efac;
                border-color: #166534;
            }
            .ts-tag-chip.invalid {
                background: #fff1f2;
                color: #9f1239;
                border-color: #fecdd3;
            }
            .dark .ts-tag-chip.invalid {
                background: rgba(159, 18, 57, 0.2);
                color: #fda4af;
                border-color: #9f1239;
            }

            /* Document Canvas & Paper */
            .ts-a4-viewport {
                width: 100%;
                background: #e2e8f0;
                background-image: radial-gradient(#cbd5e1 1.2px, transparent 1.2px);
                background-size: 24px 24px;
                border: 1px solid #cbd5e1;
                border-radius: 16px;
                padding: 30px 20px;
                display: flex;
                justify-content: center;
                overflow-x: auto;
                box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);
                min-height: 700px;
            }
            .dark .ts-a4-viewport {
                background: #090d16;
                background-image: radial-gradient(#1e293b 1.2px, transparent 1.2px);
                background-size: 24px 24px;
                border-color: #1e293b;
            }

            .ts-a4-paper {
                width: 210mm;
                min-height: 297mm;
                background-color: #ffffff !important;
                color: #000000 !important;
                padding: 20mm 20mm 20mm 25mm;
                box-sizing: border-box;
                font-family: 'Times New Roman', Times, serif;
                font-size: 12pt;
                line-height: 1.5;
                box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.25), 0 0 0 1px rgba(0, 0, 0, 0.08);
                border-radius: 2px;
                margin: 0 auto;
                text-align: left;
            }
            .ts-a4-paper * {
                box-sizing: border-box;
            }
            .ts-a4-paper table {
                border-collapse: collapse !important;
                width: 100% !important;
                margin: 4px 0 !important;
                font-family: inherit !important;
                font-size: inherit !important;
            }
            .ts-a4-paper td, 
            .ts-a4-paper th {
                border: none !important;
                padding: 2px 4px !important;
                vertical-align: top !important;
                font-family: inherit !important;
                font-size: inherit !important;
            }
            .ts-a4-paper table.bordered td,
            .ts-a4-paper table.bordered th {
                border: 1px solid #000 !important;
            }
            .ts-a4-paper p {
                margin: 0 0 6px 0 !important;
            }
            .ts-a4-paper img {
                max-width: 100% !important;
                height: auto !important;
                display: inline-block !important;
            }

            /* Print Rules */
            @media print {
                body, html {
                    background: #ffffff !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }
                .no-print, 
                .fi-sidebar, 
                .fi-topbar, 
                .fi-header,
                .fi-breadcrumbs,
                #phpdebugbar,
                .phpdebugbar {
                    display: none !important;
                }
                .ts-preview-wrapper {
                    gap: 0 !important;
                }
                .ts-a4-viewport {
                    background: transparent !important;
                    border: none !important;
                    box-shadow: none !important;
                    padding: 0 !important;
                    margin: 0 !important;
                    min-height: auto !important;
                }
                .ts-a4-paper {
                    box-shadow: none !important;
                    margin: 0 !important;
                    padding: 15mm 20mm !important;
                    width: 100% !important;
                    min-height: auto !important;
                    border: none !important;
                }
            }
        </style>

        <!-- TOP BAR: ACTIONS & CONTROLS -->
        <div class="ts-card no-print">
            <div class="ts-header-bar">
                <!-- Left: Title & Status -->
                <div class="ts-header-info">
                    <div class="ts-icon-box">
                        <svg style="width: 22px; height: 22px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="ts-title">
                            <span>{{ $template->judul }}</span>
                            @if($template->is_active)
                                <span class="ts-badge ts-badge-success">Aktif</span>
                            @else
                                <span class="ts-badge ts-badge-muted">Nonaktif</span>
                            @endif
                        </h2>
                        <div class="ts-subtitle">
                            <span>Jenis: <strong style="color: #4f46e5;">{{ $template->jenisSurat->nama ?? 'Umum' }}</strong></span>
                            <span>•</span>
                            <span>Diperbarui: {{ $template->updated_at->translatedFormat('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Interactive Actions -->
                <div class="ts-controls">
                    <!-- Mode Switcher -->
                    <div class="ts-segmented-group">
                        <button type="button" 
                                @click="viewMode = 'simulation'"
                                :class="viewMode === 'simulation' ? 'active' : ''"
                                class="ts-segmented-btn">
                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            <span>Simulasi Data</span>
                        </button>
                        <button type="button" 
                                @click="viewMode = 'placeholder'"
                                :class="viewMode === 'placeholder' ? 'active' : ''"
                                class="ts-segmented-btn">
                            <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                            <span>Tag Variabel</span>
                        </button>
                    </div>

                    <!-- Zoom Controls -->
                    <div class="ts-zoom-group">
                        <button type="button" 
                                @click="zoom = Math.max(70, zoom - 10)"
                                title="Perkecil"
                                class="ts-zoom-btn">
                            -
                        </button>
                        <span class="ts-zoom-label" x-text="zoom + '%'"></span>
                        <button type="button" 
                                @click="zoom = Math.min(130, zoom + 10)"
                                title="Perbesar"
                                class="ts-zoom-btn">
                            +
                        </button>
                    </div>

                    <!-- Print Button -->
                    <button type="button" 
                            onclick="window.print()"
                            class="ts-btn ts-btn-secondary">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        <span>Cetak A4</span>
                    </button>

                    <!-- Edit Button -->
                    <a href="{{ route('filament.admin.resources.template-surat.edit', $template) }}" 
                       class="ts-btn ts-btn-primary">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        <span>Ubah Template</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- VARIABLE ANALYSIS ACCORDION CARD -->
        <div class="ts-card no-print">
            <div class="ts-vars-header" @click="showVars = !showVars">
                <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px;">
                    <svg style="width: 18px; height: 18px; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Analisis Variabel / Tag Template Surat</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="ts-badge ts-badge-muted">Total: {{ count($placeholders) }}</span>
                    <span class="ts-badge ts-badge-success">✓ {{ count($validPlaceholders) }} Valid</span>
                    @if(count($invalidPlaceholders) > 0)
                        <span class="ts-badge" style="background: #ffe4e6; color: #9f1239;">⚠ {{ count($invalidPlaceholders) }} Tak Terdaftar</span>
                    @endif
                    <svg style="width: 16px; height: 16px; color: #94a3b8; transition: transform 0.2s;" :style="showVars ? 'transform: rotate(180deg);' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>

            <div x-show="showVars" x-collapse style="margin-top: 14px; padding-top: 12px; border-top: 1px solid #f1f5f9;">
                @if(count($placeholders) > 0)
                    <div style="display: flex; flex-wrap: wrap; gap: 8px; align-items: center;">
                        @foreach($placeholders as $ph)
                            @php $isValid = in_array($ph, $registeredPlaceholders); @endphp
                            <span @click="copyTag('{{ $ph }}')"
                                  class="ts-tag-chip {{ $isValid ? 'valid' : 'invalid' }}"
                                  title="Klik untuk menyalin tag variabel">
                                <span>{{ $isValid ? '✓' : '⚠' }} {{ $ph }}</span>
                                <span x-show="copiedTag === '{{ $ph }}'" style="font-size: 10px; font-weight: bold; color: #059669; margin-left: 2px;">(Tersalin!)</span>
                            </span>
                        @endforeach
                    </div>
                @else
                    <p style="font-size: 12px; color: #94a3b8; font-style: italic; margin: 0;">Tidak ditemukan tag variabel pada dokumen ini.</p>
                @endif
            </div>
        </div>

        <!-- A4 DOCUMENT CANVAS -->
        <div class="ts-a4-viewport">
            <div :style="'transform: scale(' + (zoom / 100) + '); transform-origin: top center; transition: transform 0.15s ease;'">
                
                <!-- SIMULATION VIEW -->
                <div x-show="viewMode === 'simulation'" class="ts-a4-paper">
                    {!! $simulatedHtml !!}
                </div>

                <!-- PLACEHOLDER HIGHLIGHTED VIEW -->
                <div x-show="viewMode === 'placeholder'" class="ts-a4-paper">
                    {!! $highlightedHtml !!}
                </div>

            </div>
        </div>

        <!-- INFO TIPS -->
        <div class="no-print" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 12px 16px; font-size: 12.5px; color: #1e40af; display: flex; align-items: flex-start; gap: 10px;">
            <svg style="width: 20px; height: 20px; min-width: 20px; color: #3b82f6; margin-top: 1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Tips Pratinjau:</strong> Gunakan mode <strong>Simulasi Data</strong> untuk melihat tampilan fisik dokumen surat saat diisi data kependudukan warga secara otomatis. Klik tombol <strong>Tag Variabel</strong> untuk memeriksa daftar variabel dan klik nama tag untuk menyalinnya ke papan klip (*clipboard*).
            </div>
        </div>
    </div>
</x-filament-panels::page>
