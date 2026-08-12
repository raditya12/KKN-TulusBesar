@props([
    'title'     => '',
    'data'      => collect(),
    'colors'    => ['#8C5A35','#2563eb','#16a34a','#d97706','#7c3aed','#0891b2'],
    'fullWidth' => false,
])

@php
    $total    = array_sum($data->toArray());
    $maxValue = $total > 0 ? max($data->toArray()) : 1;
@endphp

<div style="background:white; border:1px solid #f0e8e0; border-radius:0.875rem; padding:1.25rem; box-shadow:0 1px 4px rgba(0,0,0,0.05); {{ $fullWidth ? 'grid-column:1/-1;' : '' }}">
    <p style="font-size:0.9375rem; font-weight:700; color:#111827; margin:0 0 1rem;">{{ $title }}</p>

    @if($data->isEmpty() || $total === 0)
        <p style="font-size:0.875rem; color:#9ca3af; text-align:center; padding:1.5rem 0;">Belum ada data</p>
    @else
        <div style="display:flex; flex-direction:column; gap:0.625rem;">
            @foreach($data as $label => $value)
                @php
                    $pct      = $total > 0 ? round(($value / $total) * 100, 1) : 0;
                    $barWidth = $maxValue > 0 ? round(($value / $maxValue) * 100) : 0;
                    $color    = $colors[$loop->index % count($colors)];
                @endphp
                <div>
                    <div style="display:flex; justify-content:space-between; align-items:baseline; margin-bottom:0.25rem;">
                        <span style="font-size:0.8125rem; font-weight:500; color:#374151; flex:1; padding-right:0.5rem;">{{ $label }}</span>
                        <span style="font-size:0.8125rem; font-weight:700; color:#111827; flex-shrink:0;">{{ number_format($value) }} <span style="font-weight:400; color:#9ca3af;">({{ $pct }}%)</span></span>
                    </div>
                    <div style="height:0.5rem; background:#f3f4f6; border-radius:9999px; overflow:hidden;">
                        <div style="height:100%; width:{{ $barWidth }}%; background:{{ $color }}; border-radius:9999px; transition:width 0.4s ease;"></div>
                    </div>
                </div>
            @endforeach
        </div>

        <p style="font-size:0.75rem; color:#9ca3af; margin:0.875rem 0 0; text-align:right;">Total: {{ number_format($total) }}</p>
    @endif
</div>
