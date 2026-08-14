<x-filament-panels::page>
    {{-- ═══ LAST SYNC INFO ══════════════════════════════════════════════════ --}}
    @if($lastSync)
        <div style="display:flex; align-items:center; gap:0.5rem; padding:0.625rem 1rem; background:#fdf9f7; border:1px solid #f0e8e0; border-radius:0.5rem; font-size:0.8125rem; color:#6b7280; margin-bottom:0.25rem;">
            <x-filament::icon icon="heroicon-o-clock" style="width:1rem;height:1rem;color:#8C5A35;flex-shrink:0;" />
            <span>Terakhir diperbarui:
                <strong style="color:#374151;">{{ $lastSync->synced_at->locale('id')->translatedFormat('d F Y, H:i') }}</strong>
                &nbsp;·&nbsp;
                <span style="color:{{ $lastSync->status === 'success' ? '#16a34a' : '#d97706' }};">
                    {{ $lastSync->status === 'success' ? '✓ Berhasil' : '⚠ Sebagian berhasil' }}
                </span>
            </span>
        </div>
    @else
        <div style="display:flex; align-items:center; gap:0.5rem; padding:0.625rem 1rem; background:#f9fafb; border:1px solid #e5e7eb; border-radius:0.5rem; font-size:0.8125rem; color:#9ca3af;">
            <x-filament::icon icon="heroicon-o-clock" style="width:1rem;height:1rem;flex-shrink:0;" />
            <span>Belum pernah disinkronkan. Klik <strong>↻ Tarik Data</strong> untuk mulai.</span>
        </div>
    @endif

    {{-- ═══ STATS CARDS ══════════════════════════════════════════════════════ --}}
    <div style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">
        @php
            $stats = [
                ['label' => 'Total Penduduk', 'value' => number_format($totalPenduduk), 'icon' => 'heroicon-o-users', 'color' => '#8C5A35', 'bg' => '#fff7ed'],
                ['label' => 'Kepala Keluarga', 'value' => number_format($totalKK), 'icon' => 'heroicon-o-home', 'color' => '#2563eb', 'bg' => '#eff6ff'],
                ['label' => 'Laki-laki', 'value' => number_format($lakiLaki), 'icon' => 'heroicon-o-user', 'color' => '#0891b2', 'bg' => '#ecfeff'],
                ['label' => 'Perempuan', 'value' => number_format($perempuan), 'icon' => 'heroicon-o-user', 'color' => '#be185d', 'bg' => '#fdf2f8'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.25rem; display:flex; align-items:center; gap:1rem; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
                <div style="flex-shrink:0; width:2.75rem; height:2.75rem; border-radius:9999px; background:{{ $stat['bg'] }}; display:flex; align-items:center; justify-content:center;">
                    <x-filament::icon :icon="$stat['icon']" style="width:1.375rem;height:1.375rem;color:{{ $stat['color'] }};" />
                </div>
                <div>
                    <p style="font-size:0.75rem; color:#6b7280; margin:0 0 0.125rem; font-weight:500;">{{ $stat['label'] }}</p>
                    <p style="font-size:1.5rem; font-weight:800; color:#111827; margin:0; line-height:1.2;">{{ $stat['value'] }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ═══ SYNC RESULT (jika baru saja sync) ═══════════════════════════════ --}}
    @if($syncResult)
        <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:0.875rem; padding:1.25rem;">
            <div style="display:flex; align-items:center; gap:0.5rem; margin-bottom:0.875rem;">
                <x-filament::icon icon="heroicon-o-check-circle" style="width:1.25rem;height:1.25rem;color:#16a34a;" />
                <p style="font-size:0.9375rem; font-weight:700; color:#15803d; margin:0;">Ringkasan Sinkronisasi Terakhir</p>
            </div>
            <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:0.75rem;">
                @php
                    $items = [
                        ['label' => 'Keluarga baru', 'value' => $syncResult['families_inserted'], 'color' => '#16a34a'],
                        ['label' => 'Keluarga diperbarui', 'value' => $syncResult['families_updated'], 'color' => '#2563eb'],
                        ['label' => 'Anggota baru', 'value' => $syncResult['members_inserted'], 'color' => '#16a34a'],
                        ['label' => 'Anggota diperbarui', 'value' => $syncResult['members_updated'], 'color' => '#2563eb'],
                        ['label' => 'Dilewati', 'value' => $syncResult['rows_skipped'], 'color' => '#6b7280'],
                        ['label' => 'Error', 'value' => $syncResult['error_count'], 'color' => $syncResult['error_count'] > 0 ? '#dc2626' : '#16a34a'],
                    ];
                @endphp
                @foreach($items as $item)
                    <div style="background:white; border-radius:0.5rem; padding:0.75rem 1rem; border:1px solid #dcfce7;">
                        <p style="font-size:0.75rem; color:#6b7280; margin:0 0 0.25rem;">{{ $item['label'] }}</p>
                        <p style="font-size:1.25rem; font-weight:800; color:{{ $item['color'] }}; margin:0;">{{ $item['value'] }}</p>
                    </div>
                @endforeach
            </div>

            @if(!empty($syncResult['error_details']))
                <div style="margin-top:0.875rem; padding:0.75rem 1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:0.5rem;">
                    <p style="font-size:0.8125rem; font-weight:600; color:#dc2626; margin:0 0 0.5rem;">Detail Error:</p>
                    @foreach($syncResult['error_details'] as $err)
                        <p style="font-size:0.8rem; color:#7f1d1d; margin:0 0 0.25rem;">
                            • Baris {{ $err['row'] }} ({{ $err['nama'] }}): {{ $err['error'] }}
                        </p>
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    {{-- ═══ LINK KE DATA WARGA ══════════════════════════════════════════════ --}}
    <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.5rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <div style="display:flex; align-items:center; gap:0.875rem;">
            <div style="width:2.75rem; height:2.75rem; border-radius:9999px; background:#fff7ed; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <x-filament::icon icon="heroicon-o-users" style="width:1.375rem;height:1.375rem;color:#8C5A35;" />
            </div>
            <div>
                <p style="font-size:0.9375rem; font-weight:700; color:#111827; margin:0 0 0.125rem;">Lihat Data Warga</p>
                <p style="font-size:0.8rem; color:#6b7280; margin:0;">Telusuri, cari, dan filter seluruh data penduduk.</p>
            </div>
        </div>
        <a href="{{ \App\Filament\Resources\Penduduk\PendudukResource::getUrl('index') }}"
           style="display:inline-flex; align-items:center; gap:0.375rem; padding:0.5625rem 1.25rem; background:#8C5A35; color:#fff; border-radius:0.5rem; font-size:0.875rem; font-weight:600; text-decoration:none; transition:background 0.15s;"
           onmouseover="this.style.background='#7a4e2d';"
           onmouseout="this.style.background='#8C5A35';">
            Lihat Data Warga
            <x-filament::icon icon="heroicon-m-arrow-right" style="width:0.875rem;height:0.875rem;" />
        </a>
    </div>

    {{-- ═══ LINK KE DEMOGRAFI ════════════════════════════════════════════════ --}}
    <div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.5rem; display:flex; align-items:center; justify-content:space-between; box-shadow:0 1px 4px rgba(0,0,0,0.05);">
        <div style="display:flex; align-items:center; gap:0.875rem;">
            <div style="width:2.75rem; height:2.75rem; border-radius:9999px; background:#eff6ff; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <x-filament::icon icon="heroicon-o-chart-bar" style="width:1.375rem;height:1.375rem;color:#2563eb;" />
            </div>
            <div>
                <p style="font-size:0.9375rem; font-weight:700; color:#111827; margin:0 0 0.125rem;">Lihat Demografi</p>
                <p style="font-size:0.8rem; color:#6b7280; margin:0;">Visualisasi statistik demografis penduduk desa.</p>
            </div>
        </div>
        <a href="{{ \App\Filament\Pages\DemografiPage::getUrl() }}"
           style="display:inline-flex; align-items:center; gap:0.375rem; padding:0.5625rem 1.25rem; background:#2563eb; color:#fff; border-radius:0.5rem; font-size:0.875rem; font-weight:600; text-decoration:none; transition:background 0.15s;"
           onmouseover="this.style.background='#1d4ed8';"
           onmouseout="this.style.background='#2563eb';">
            Lihat Demografi
            <x-filament::icon icon="heroicon-m-arrow-right" style="width:0.875rem;height:0.875rem;" />
        </a>
    </div>
</x-filament-panels::page>
