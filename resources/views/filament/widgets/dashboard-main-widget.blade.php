<x-filament-widgets::widget>
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">

        {{-- ═══ ARSIP SURAT TERBARU ═══ --}}
        <div style="background: white; border: 1px solid #f0e8e0; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            {{-- Header --}}
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid #f5ece4;">
                <div style="display: flex; align-items: center; gap: 0.625rem;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 9999px; background: #fff7ed;">
                        <x-filament::icon icon="heroicon-o-archive-box" style="width: 1.1rem; height: 1.1rem; color: #8C5A35;" />
                    </span>
                    <div>
                        <p style="font-size: 0.9375rem; font-weight: 700; color: #111827; margin: 0; line-height: 1.3;">Arsip Surat Terbaru</p>
                        <p style="font-size: 0.8rem; color: #9ca3af; margin: 0; line-height: 1.3;">5 arsip surat paling baru.</p>
                    </div>
                </div>
                <a href="{{ $arsipUrl }}"
                   style="font-size: 0.8125rem; color: #8C5A35; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.375rem 0.75rem; border: 1px solid #f0e8e0; border-radius: 0.5rem; background: #fdf9f7; transition: background 0.15s;"
                   onmouseover="this.style.background='#f5ece4';"
                   onmouseout="this.style.background='#fdf9f7';">
                    Lihat Semua <x-filament::icon icon="heroicon-m-arrow-right" style="width: 0.875rem; height: 0.875rem;" />
                </a>
            </div>

            {{-- Body --}}
            @if($arsipTerbaru->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                        <thead>
                            <tr style="background: #fdf9f7;">
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Nomor Surat</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Nama Pemohon</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Tanggal Arsip</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Dokumen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($arsipTerbaru as $i => $surat)
                                @php
                                    $ext = $surat->file_dokumen ? strtoupper(pathinfo($surat->file_dokumen, PATHINFO_EXTENSION)) : null;
                                    $extColor = match(strtolower($ext ?? '')) {
                                        'pdf'  => 'color:#dc2626; background:#fef2f2; border-color:#fecaca;',
                                        'docx', 'doc' => 'color:#2563eb; background:#eff6ff; border-color:#bfdbfe;',
                                        default => 'color:#6b7280; background:#f9fafb; border-color:#e5e7eb;',
                                    };
                                @endphp
                                <tr style="background: {{ $i % 2 === 0 ? '#ffffff' : '#fdfcfb' }}; transition: background 0.1s;"
                                    onmouseover="this.style.background='#fdf7f3';"
                                    onmouseout="this.style.background='{{ $i % 2 === 0 ? '#ffffff' : '#fdfcfb' }}';">
                                    <td style="padding: 0.875rem 1.25rem; font-family: 'Courier New', monospace; font-size: 0.8rem; font-weight: 700; color: #374151; border-top: 1px solid #f5ece4;">
                                        {{ $surat->nomor_surat }}
                                    </td>
                                    <td style="padding: 0.875rem 1.25rem; font-weight: 600; color: #111827; border-top: 1px solid #f5ece4;">
                                        {{ $surat->nama_pemohon }}
                                    </td>
                                    <td style="padding: 0.875rem 1.25rem; color: #6b7280; font-size: 0.8rem; border-top: 1px solid #f5ece4;">
                                        {{ $surat->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td style="padding: 0.875rem 1.25rem; border-top: 1px solid #f5ece4;">
                                        @if($surat->file_dokumen)
                                            <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.6rem; font-size: 0.75rem; font-weight: 700; border-radius: 9999px; border: 1px solid; {{ $extColor }}">
                                                {{ $ext }}
                                            </span>
                                        @else
                                            <span style="color: #9ca3af; font-size: 0.8rem;">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                    <div style="width: 3.5rem; height: 3.5rem; background: #fdf9f7; border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        <x-filament::icon icon="heroicon-o-archive-box" style="width: 1.75rem; height: 1.75rem; color: #8C5A35;" />
                    </div>
                    <p style="font-size: 0.9375rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem;">Belum ada arsip surat.</p>
                    <p style="font-size: 0.8rem; color: #9ca3af; margin: 0 0 1rem;">Mulai arsipkan dokumen surat melalui menu Arsip Surat.</p>
                    <a href="{{ $arsipUrl }}"
                       style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1.25rem; font-size: 0.875rem; font-weight: 600; background: #8C5A35; color: #fff; border-radius: 0.5rem; text-decoration: none; transition: background 0.15s;"
                       onmouseover="this.style.background='#7a4e2d';"
                       onmouseout="this.style.background='#8C5A35';">
                        <x-filament::icon icon="heroicon-o-plus-circle" style="width: 1rem; height: 1rem;" />
                        Tambah Arsip Surat
                    </a>
                </div>
            @endif
        </div>

    </div>
</x-filament-widgets::widget>
