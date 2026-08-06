@php
    $html = $get('konten_html') ?? '';
    $placeholderService = app(\App\Services\Surat\PlaceholderService::class);
    $placeholders = $placeholderService->extractPlaceholders($html);
    $registeredPlaceholders = \App\Models\MasterPlaceholder::pluck('placeholder')->toArray();
    $validPlaceholders = array_intersect($placeholders, $registeredPlaceholders);
    $invalidPlaceholders = array_diff($placeholders, $registeredPlaceholders);

    // Realistic sample resident dataset for simulation mode
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

    // Replace for simulation mode
    $simulatedHtml = $html;
    foreach ($sampleData as $key => $val) {
        $simulatedHtml = str_replace('{{'.$key.'}}', '<strong>'.$val.'</strong>', $simulatedHtml);
    }

    // Highlight placeholders for variable tag mode
    $highlightedHtml = $html;
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
     class="ts-live-preview-wrapper">

    <style>
        .ts-live-preview-wrapper {
            display: flex;
            flex-direction: column;
            gap: 16px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            font-family: inherit;
        }

        /* Top Controls Bar */
        .ts-live-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }
        .dark .ts-live-card {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }

        .ts-live-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .ts-live-pulse {
            width: 9px;
            height: 9px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
            animation: ts-live-pulse-anim 2s infinite;
        }
        @keyframes ts-live-pulse-anim {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4); }
            70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        /* Mode Switcher Buttons */
        .ts-live-segmented-group {
            display: inline-flex;
            background: #f1f5f9;
            padding: 3px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .dark .ts-live-segmented-group {
            background: #0f172a;
            border-color: #334155;
        }
        .ts-live-segmented-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: none;
            cursor: pointer;
            transition: all 0.15s ease;
        }
        .dark .ts-live-segmented-btn {
            color: #94a3b8;
        }
        .ts-live-segmented-btn.active {
            background: #ffffff;
            color: #4f46e5;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .dark .ts-live-segmented-btn.active {
            background: #334155;
            color: #818cf8;
        }

        /* Zoom Controls */
        .ts-live-zoom-group {
            display: inline-flex;
            align-items: center;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 2px 4px;
        }
        .dark .ts-live-zoom-group {
            background: #0f172a;
            border-color: #334155;
        }
        .ts-live-zoom-btn {
            background: transparent;
            border: none;
            color: #64748b;
            font-weight: bold;
            font-size: 13px;
            padding: 3px 8px;
            cursor: pointer;
            border-radius: 4px;
        }
        .ts-live-zoom-btn:hover {
            background: #e2e8f0;
            color: #0f172a;
        }
        .dark .ts-live-zoom-btn:hover {
            background: #334155;
            color: #f8fafc;
        }
        .ts-live-zoom-label {
            font-size: 11px;
            font-family: monospace;
            font-weight: 600;
            color: #475569;
            padding: 0 6px;
            min-width: 38px;
            text-align: center;
        }
        .dark .ts-live-zoom-label {
            color: #cbd5e1;
        }

        /* Variable Analysis Card */
        .ts-live-vars-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 18px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .dark .ts-live-vars-card {
            background: #1e293b;
            border-color: #334155;
            color: #f8fafc;
        }
        .ts-live-vars-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            user-select: none;
        }
        .ts-live-tag-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 8px;
            border-radius: 6px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            font-size: 11.5px;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }
        .ts-live-tag-chip.valid {
            background: #f0fdf4;
            color: #166534;
            border-color: #bbf7d0;
        }
        .ts-live-tag-chip.valid:hover {
            background: #dcfce7;
            border-color: #86efac;
        }
        .dark .ts-live-tag-chip.valid {
            background: rgba(22, 101, 52, 0.2);
            color: #86efac;
            border-color: #166534;
        }
        .ts-live-tag-chip.invalid {
            background: #fff1f2;
            color: #9f1239;
            border-color: #fecdd3;
        }
        .dark .ts-live-tag-chip.invalid {
            background: rgba(159, 18, 57, 0.2);
            color: #fda4af;
            border-color: #9f1239;
        }

        /* Workspace Canvas & A4 Sheet */
        .ts-live-workspace {
            position: relative;
            width: 100%;
            height: 650px;
            max-height: 650px;
            overflow-y: scroll;
            overflow-x: auto;
            background-color: #e2e8f0;
            background-image: radial-gradient(#cbd5e1 1.2px, transparent 1.2px);
            background-size: 24px 24px;
            border: 1px solid #cbd5e1;
            border-radius: 14px;
            padding: 30px 16px;
            box-sizing: border-box;
            display: flex;
            justify-content: center;
            box-shadow: inset 0 2px 6px rgba(0,0,0,0.06);
        }
        .dark .ts-live-workspace {
            background-color: #090d16;
            background-image: radial-gradient(#1e293b 1.2px, transparent 1.2px);
            border-color: #1e293b;
        }

        .ts-live-sheet {
            width: 210mm;
            min-height: 297mm;
            background-color: #ffffff !important;
            color: #000000 !important;
            padding: 20mm 20mm 20mm 25mm;
            box-sizing: border-box;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.5;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.25), 0 0 0 1px rgba(0,0,0,0.08);
            border-radius: 2px;
            margin: 0 auto;
            text-align: left;
        }
        .ts-live-sheet * {
            box-sizing: border-box;
        }
        .ts-live-sheet table {
            border-collapse: collapse !important;
            width: 100% !important;
            margin: 4px 0 !important;
            font-family: inherit !important;
            font-size: inherit !important;
        }
        .ts-live-sheet td, .ts-live-sheet th {
            border: none !important;
            padding: 2px 4px !important;
            vertical-align: top !important;
            font-family: inherit !important;
            font-size: inherit !important;
        }
        .ts-live-sheet table.bordered td, .ts-live-sheet table.bordered th {
            border: 1px solid #000 !important;
        }
        .ts-live-sheet p {
            margin: 0 0 6px 0 !important;
        }
        .ts-live-sheet img {
            max-width: 100% !important;
            height: auto !important;
            display: inline-block !important;
        }
    </style>

    <!-- TOP CONTROLS BAR -->
    <div class="ts-live-card">
        <div class="ts-live-info">
            <span class="ts-live-pulse"></span>
            <div>
                <span style="font-weight: 700; font-size: 13.5px;">Pratinjau Fisik Format A4</span>
                <span style="font-size: 11px; color: #64748b; margin-left: 6px;">(Sinkronisasi Otomatis)</span>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
            <!-- Mode Switcher -->
            <div class="ts-live-segmented-group">
                <button type="button" 
                        @click="viewMode = 'simulation'"
                        :class="viewMode === 'simulation' ? 'active' : ''"
                        class="ts-live-segmented-btn">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <span>Simulasi Data</span>
                </button>
                <button type="button" 
                        @click="viewMode = 'placeholder'"
                        :class="viewMode === 'placeholder' ? 'active' : ''"
                        class="ts-live-segmented-btn">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <span>Tag Variabel</span>
                </button>
            </div>

            <!-- Zoom Controls -->
            <div class="ts-live-zoom-group">
                <button type="button" 
                        @click="zoom = Math.max(70, zoom - 10)"
                        title="Perkecil"
                        class="ts-live-zoom-btn">
                    -
                </button>
                <span class="ts-live-zoom-label" x-text="zoom + '%'"></span>
                <button type="button" 
                        @click="zoom = Math.min(130, zoom + 10)"
                        title="Perbesar"
                        class="ts-live-zoom-btn">
                    +
                </button>
            </div>
        </div>
    </div>

    <!-- VARIABLE ANALYSIS ACCORDION CARD -->
    <div class="ts-live-vars-card">
        <div class="ts-live-vars-header" @click="showVars = !showVars">
            <div style="display: flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13px;">
                <svg style="width: 16px; height: 16px; color: #4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Analisis Variabel / Tag Template Surat</span>
            </div>
            <div style="display: flex; align-items: center; gap: 8px;">
                <span style="font-size: 11px; background: #f1f5f9; color: #475569; padding: 2px 7px; border-radius: 5px; font-weight: 600;">Total: {{ count($placeholders) }}</span>
                <span style="font-size: 11px; background: #dcfce7; color: #15803d; padding: 2px 7px; border-radius: 5px; font-weight: 600;">✓ {{ count($validPlaceholders) }} Valid</span>
                @if(count($invalidPlaceholders) > 0)
                    <span style="font-size: 11px; background: #ffe4e6; color: #9f1239; padding: 2px 7px; border-radius: 5px; font-weight: 600;">⚠ {{ count($invalidPlaceholders) }} Tak Terdaftar</span>
                @endif
                <svg style="width: 15px; height: 15px; color: #94a3b8; transition: transform 0.2s;" :style="showVars ? 'transform: rotate(180deg);' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>

        <div x-show="showVars" x-collapse style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
            @if(count($placeholders) > 0)
                <div style="display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
                    @foreach($placeholders as $ph)
                        @php $isValid = in_array($ph, $registeredPlaceholders); @endphp
                        <span @click="copyTag('{{ $ph }}')"
                              class="ts-live-tag-chip {{ $isValid ? 'valid' : 'invalid' }}"
                              title="Klik untuk menyalin tag variabel">
                            <span>{{ $isValid ? '✓' : '⚠' }} {{ $ph }}</span>
                            <span x-show="copiedTag === '{{ $ph }}'" style="font-size: 9.5px; font-weight: bold; color: #059669; margin-left: 2px;">(Tersalin!)</span>
                        </span>
                    @endforeach
                </div>
            @else
                <p style="font-size: 11.5px; color: #94a3b8; font-style: italic; margin: 0;">Belum ada tag variabel ditemukan. Tambahkan seperti <code>@{{nama}}</code> pada editor.</p>
            @endif
        </div>
    </div>

    <!-- WORKSPACE VIEWPORT -->
    <div class="ts-live-workspace">
        @if(trim($html))
            <div :style="'transform: scale(' + (zoom / 100) + '); transform-origin: top center; transition: transform 0.15s ease;'">
                <!-- Simulation View -->
                <div x-show="viewMode === 'simulation'" class="ts-live-sheet">
                    {!! $simulatedHtml !!}
                </div>

                <!-- Placeholder Highlighted View -->
                <div x-show="viewMode === 'placeholder'" class="ts-live-sheet">
                    {!! $highlightedHtml !!}
                </div>
            </div>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100%; text-align: center; color: #64748b;">
                <div style="background: rgba(148, 163, 184, 0.15); border-radius: 50%; padding: 16px; margin-bottom: 12px;">
                    <svg style="width: 36px; height: 36px; color: #94a3b8;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 01-2-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h5 style="font-size: 14px; font-weight: 600; color: #334155; margin: 0 0 4px 0;">Belum Ada Konten Template</h5>
                <p style="font-size: 12px; color: #64748b; max-width: 280px; margin: 0;">
                    Tuliskan isi template pada tab Editor Template atau unggah file .docx untuk melihat pratinjau A4 secara real-time.
                </p>
            </div>
        @endif
    </div>
</div>
