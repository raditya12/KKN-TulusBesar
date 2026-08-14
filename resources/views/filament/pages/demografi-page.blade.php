<x-filament-panels::page>

    {{-- ═══ STATS UTAMA ══════════════════════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
        @php
            $statsUtama = [
                ['label' => 'Total Penduduk', 'value' => number_format($totalPenduduk), 'icon' => 'heroicon-o-users', 'color' => '#8C5A35', 'bg' => '#fff7ed'],
                ['label' => 'Kepala Keluarga', 'value' => number_format($totalKK), 'icon' => 'heroicon-o-home', 'color' => '#2563eb', 'bg' => '#eff6ff'],
                ['label' => 'Laki-laki', 'value' => number_format($lakiLaki), 'icon' => 'heroicon-o-user', 'color' => '#0891b2', 'bg' => '#ecfeff'],
                ['label' => 'Perempuan', 'value' => number_format($perempuan), 'icon' => 'heroicon-o-user', 'color' => '#be185d', 'bg' => '#fdf2f8'],
            ];
        @endphp
        @foreach($statsUtama as $s)
            <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.25rem; display:flex; align-items:center; gap:1rem; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <div style="flex-shrink:0; width:2.75rem; height:2.75rem; border-radius:9999px; background:{{ $s['bg'] }}; display:flex; align-items:center; justify-content:center;">
                    <x-filament::icon :icon="$s['icon']" style="width:1.375rem;height:1.375rem;color:{{ $s['color'] }};" />
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#6b7280; margin:0 0 0.125rem; font-weight:500;">{{ $s['label'] }}</p>
                    <p style="font-size:1.5rem; font-weight:800; color:#111827; margin:0; line-height:1.2;">{{ $s['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ═══ GRID CHARTS ═══════════════════════════════════════════════════════ --}}
    @if($totalPenduduk === 0)
        <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:3rem; text-align:center; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
            <x-filament::icon icon="heroicon-o-chart-bar" style="width:3rem;height:3rem;color:#d1d5db;margin:0 auto 1rem;" />
            <p style="font-size:1rem; font-weight:700; color:#374151; margin:0 0 0.375rem;">Belum ada data untuk divisualisasikan</p>
            <p style="font-size:0.875rem; color:#9ca3af; margin:0;">Tarik data dari Google Sheets terlebih dahulu melalui halaman Data Penduduk.</p>
        </div>
    @else
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

            {{-- Jenis Kelamin --}}
            <x-demografi-card title="Jenis Kelamin" :data="$byJenisKelamin" :colors="['#0891b2','#be185d','#6b7280']" />

            {{-- Agama --}}
            <x-demografi-card title="Agama" :data="$byAgama" :colors="['#8C5A35','#2563eb','#16a34a','#d97706','#7c3aed','#dc2626','#0891b2']" />

        </div>

        {{-- Kelompok Umur (full width) --}}
        <x-demografi-card title="Kelompok Umur" :data="$byKelompokUmur" :full-width="true"
            :colors="['#6366f1','#8b5cf6','#a78bfa','#c4b5fd','#ddd6fe','#ede9fe','#f5f3ff','#9ca3af']" />

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">

            {{-- Per Dusun --}}
            <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <p style="font-size:0.9375rem; font-weight:700; color:#111827; margin:0 0 1rem;">Penduduk per Dusun</p>
                <table style="width:100%; border-collapse:collapse; font-size:0.8375rem;">
                    <thead>
                        <tr style="border-bottom:2px solid #f5ece4;">
                            <th style="text-align:left; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">Dusun</th>
                            <th style="text-align:right; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">KK</th>
                            <th style="text-align:right; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">Warga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byDusun as $d)
                            <tr style="border-bottom:1px solid #f5ece4;" onmouseover="this.style.background='#fdf9f7'" onmouseout="this.style.background='transparent'">
                                <td style="padding:0.625rem 0.75rem; font-weight:600; color:#111827;">{{ $d['dusun'] ?: '-' }}</td>
                                <td style="padding:0.625rem 0.75rem; text-align:right; color:#6b7280;">{{ $d['total_kk'] }}</td>
                                <td style="padding:0.625rem 0.75rem; text-align:right; font-weight:700; color:#8C5A35;">{{ $d['total_warga'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Per RW --}}
            <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <p style="font-size:0.9375rem; font-weight:700; color:#111827; margin:0 0 1rem;">Penduduk per RW</p>
                <table style="width:100%; border-collapse:collapse; font-size:0.8375rem;">
                    <thead>
                        <tr style="border-bottom:2px solid #f5ece4;">
                            <th style="text-align:left; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">RW</th>
                            <th style="text-align:right; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">KK</th>
                            <th style="text-align:right; padding:0.5rem 0.75rem; color:#6b7280; font-weight:600; font-size:0.75rem; text-transform:uppercase;">Warga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($byRw as $r)
                            <tr style="border-bottom:1px solid #f5ece4;" onmouseover="this.style.background='#fdf9f7'" onmouseout="this.style.background='transparent'">
                                <td style="padding:0.625rem 0.75rem; font-weight:600; color:#111827;">RW {{ $r['rw'] ?: '-' }}</td>
                                <td style="padding:0.625rem 0.75rem; text-align:right; color:#6b7280;">{{ $r['total_kk'] }}</td>
                                <td style="padding:0.625rem 0.75rem; text-align:right; font-weight:700; color:#8C5A35;">{{ $r['total_warga'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            {{-- Pendidikan --}}
            <x-demografi-card title="Tingkat Pendidikan" :data="$byPendidikan"
                :colors="['#8C5A35','#d97706','#16a34a','#2563eb','#7c3aed','#0891b2','#dc2626','#6b7280','#f59e0b','#84cc16']" />

            {{-- Pekerjaan --}}
            <x-demografi-card title="Jenis Pekerjaan" :data="$byPekerjaan"
                :colors="['#2563eb','#16a34a','#d97706','#dc2626','#7c3aed','#0891b2','#8C5A35','#6b7280','#f59e0b','#84cc16']" />
        </div>
    @endif

</x-filament-panels::page>
