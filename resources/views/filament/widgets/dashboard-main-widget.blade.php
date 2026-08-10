<x-filament-widgets::widget>
    <div style="display: flex; flex-direction: column; gap: 1.25rem;">

        {{-- ═══ AKSES CEPAT ═══ --}}
        <x-filament::section>
            <x-slot name="heading">Akses Cepat</x-slot>

            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 0.875rem;">
                @foreach($links as $link)
                    @php
                        $shadowNormal = $link['primary']
                            ? '0 4px 14px rgba(140,90,53,0.35)'
                            : '0 1px 4px rgba(0,0,0,0.06)';
                        $shadowHover = $link['primary']
                            ? '0 10px 22px rgba(140,90,53,0.45)'
                            : '0 4px 14px rgba(0,0,0,0.12)';
                        $bgStyle = $link['primary']
                            ? 'background:linear-gradient(135deg,#8C5A35,#a06840);border:none;'
                            : 'background:rgba(255,255,255,0.7);border:1px solid #f0e8e0;';
                    @endphp
                    <a href="{{ $link['url'] }}"
                       data-shadow-normal="{{ $shadowNormal }}"
                       data-shadow-hover="{{ $shadowHover }}"
                       class="qlink-card"
                       style="{{ $bgStyle }} display:flex; flex-direction:column; align-items:center; justify-content:center; padding:1.5rem 1rem; border-radius:0.875rem; text-align:center; text-decoration:none; gap:0.625rem; box-shadow:{{ $shadowNormal }}; transform:translateY(0); transition:transform 0.2s ease, box-shadow 0.2s ease; cursor:pointer;">
                        <span style="display:inline-flex;align-items:center;justify-content:center;width:2.75rem;height:2.75rem;border-radius:9999px;{{ $link['primary'] ? 'background:rgba(255,255,255,0.2);color:#ffffff;' : 'background:rgba(140,90,53,0.08);color:#8C5A35;' }}">
                            <x-filament::icon :icon="$link['icon']" style="width:1.35rem;height:1.35rem;" />
                        </span>
                        <span style="font-size:0.875rem;font-weight:600;letter-spacing:0.01em;{{ $link['primary'] ? 'color:#ffffff;' : 'color:#374151;' }}">
                            {{ $link['name'] }}
                        </span>
                    </a>
                @endforeach
            </div>

            <script>
                (function() {
                    function initQlinks() {
                        document.querySelectorAll('.qlink-card').forEach(function(el) {
                            el.addEventListener('mouseenter', function() {
                                this.style.transform = 'translateY(-3px)';
                                this.style.boxShadow = this.dataset.shadowHover;
                            });
                            el.addEventListener('mouseleave', function() {
                                this.style.transform = 'translateY(0)';
                                this.style.boxShadow = this.dataset.shadowNormal;
                            });
                        });
                    }
                    if (document.readyState === 'loading') {
                        document.addEventListener('DOMContentLoaded', initQlinks);
                    } else {
                        initQlinks();
                    }
                    document.addEventListener('livewire:navigated', initQlinks);
                })();
            </script>
        </x-filament::section>

        {{-- ═══ PERLU TINDAKAN ═══ --}}
        <div style="background: white; border: 1px solid #f0e8e0; border-radius: 0.875rem; overflow: hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
            {{-- Header --}}
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.25rem; border-bottom: 1px solid #f5ece4;">
                <div style="display: flex; align-items: center; gap: 0.625rem;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 2rem; height: 2rem; border-radius: 9999px; background: #fff7ed;">
                        <x-filament::icon icon="heroicon-o-exclamation-triangle" style="width: 1.1rem; height: 1.1rem; color: #d97706;" />
                    </span>
                    <div>
                        <p style="font-size: 0.9375rem; font-weight: 700; color: #111827; margin: 0; line-height: 1.3;">Perlu Tindakan</p>
                        <p style="font-size: 0.8rem; color: #9ca3af; margin: 0; line-height: 1.3;">Surat yang belum memiliki scan.</p>
                    </div>
                </div>
                @if($perluTindakan->count() > 0)
                    <a href="{{ \App\Filament\Resources\Surat\SuratResource::getUrl() }}"
                       style="font-size: 0.8125rem; color: #8C5A35; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 0.25rem; padding: 0.375rem 0.75rem; border: 1px solid #f0e8e0; border-radius: 0.5rem; background: #fdf9f7; transition: background 0.15s;"
                       onmouseover="this.style.background='#f5ece4';"
                       onmouseout="this.style.background='#fdf9f7';">
                        Lihat Semua <x-filament::icon icon="heroicon-m-arrow-right" style="width: 0.875rem; height: 0.875rem;" />
                    </a>
                @endif
            </div>

            {{-- Body --}}
            @if($perluTindakan->count() > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                        <thead>
                            <tr style="background: #fdf9f7;">
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Nomor Surat</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Jenis Surat</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Nama Pemohon</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Tanggal</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: left; border-bottom: 1px solid #f5ece4;">Status</th>
                                <th style="padding: 0.6875rem 1.25rem; font-weight: 600; color: #6b7280; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; text-align: right; border-bottom: 1px solid #f5ece4;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($perluTindakan as $i => $surat)
                                <tr style="background: {{ $i % 2 === 0 ? '#ffffff' : '#fdfcfb' }}; transition: background 0.1s;"
                                    onmouseover="this.style.background='#fdf7f3';"
                                    onmouseout="this.style.background='{{ $i % 2 === 0 ? '#ffffff' : '#fdfcfb' }}';">
                                    <td style="padding: 0.875rem 1.25rem; font-family: 'Courier New', monospace; font-size: 0.8rem; font-weight: 700; color: #374151; border-top: 1px solid #f5ece4;">{{ $surat->nomor_surat }}</td>
                                    <td style="padding: 0.875rem 1.25rem; border-top: 1px solid #f5ece4;">
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; color: #8C5A35; background: rgba(140,90,53,0.08); border-radius: 9999px; border: 1px solid rgba(140,90,53,0.15);">
                                            {{ $surat->jenisSurat->nama_surat ?? '-' }}
                                        </span>
                                    </td>
                                    <td style="padding: 0.875rem 1.25rem; font-weight: 600; color: #111827; border-top: 1px solid #f5ece4;">{{ $surat->nama_pemohon }}</td>
                                    <td style="padding: 0.875rem 1.25rem; color: #6b7280; font-size: 0.8rem; border-top: 1px solid #f5ece4;">{{ $surat->created_at->format('d M Y, H:i') }}</td>
                                    <td style="padding: 0.875rem 1.25rem; border-top: 1px solid #f5ece4;">
                                        <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.625rem; font-size: 0.75rem; font-weight: 600; color: #b45309; background: #fff7ed; border-radius: 9999px; border: 1px solid #fde68a;">
                                            Belum Upload
                                        </span>
                                    </td>
                                    <td style="padding: 0.875rem 1.25rem; text-align: right; border-top: 1px solid #f5ece4;">
                                        <a href="{{ \App\Filament\Resources\Surat\SuratResource::getUrl('index') }}"
                                           style="display: inline-flex; align-items: center; gap: 0.35rem; padding: 0.4rem 0.875rem; font-size: 0.8rem; font-weight: 600; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.5rem; color: #15803d; text-decoration: none; transition: background 0.15s;"
                                           onmouseover="this.style.background='#dcfce7';"
                                           onmouseout="this.style.background='#f0fdf4';">
                                            <x-filament::icon icon="heroicon-o-arrow-up-tray" style="width: 0.9rem; height: 0.9rem;" />
                                            Upload Scan
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: 3rem 2rem; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                    <div style="width: 3.5rem; height: 3.5rem; background: #f0fdf4; border-radius: 9999px; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                        <x-filament::icon icon="heroicon-o-check-badge" style="width: 1.75rem; height: 1.75rem; color: #16a34a;" />
                    </div>
                    <p style="font-size: 0.9375rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem;">Semua arsip sudah memiliki scan.</p>
                    <p style="font-size: 0.8rem; color: #9ca3af; margin: 0;">Tidak ada surat yang membutuhkan tindakan saat ini.</p>
                </div>
            @endif
        </div>

    </div>
</x-filament-widgets::widget>
