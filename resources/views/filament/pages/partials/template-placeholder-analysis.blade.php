{{-- ── Placeholder Analysis Panel ──────────────────────────────────────── --}}
@if ($analysis)
    @php
        $hasDuplicates = !empty($analysis['duplicates']);
        $hasMalformed  = !empty($analysis['malformed']);
        $hasIssues     = $analysis['has_issues'];
        $validCount    = count($analysis['valid']);
        $totalUnique   = $validCount + count($analysis['duplicates']);
    @endphp

    {{-- Warning Banner --}}
    @if ($hasIssues)
        <div style="margin-bottom:1rem; padding:0.875rem 1rem; background:#fff7ed; border:1.5px solid #f59e0b; border-radius:0.5rem;">
            <div style="display:flex; align-items:center; gap:0.4rem; margin-bottom:0.5rem;">
                <span>⚠️</span>
                <strong style="color:#92400e; font-size:0.875rem;">Ada data yang bermasalah</strong>
            </div>

            @if ($hasDuplicates)
                <p style="color:#78350f; font-size:0.82rem; margin:0 0 0.4rem 0; font-weight:600;">Data digunakan lebih dari satu kali:</p>
                @foreach ($analysis['duplicates'] as $key => $count)
                    <div style="display:flex; align-items:center; gap:0.4rem; margin-bottom:0.2rem; font-size:0.82rem;">
                        <span style="color:#f59e0b;">⚠</span>
                        <code style="background:#fef3c7; padding:0.1rem 0.4rem; border-radius:0.2rem; color:#92400e;">[{{ $key }}]</code>
                        <span style="color:#78350f;">ditemukan {{ $count }} kali</span>
                    </div>
                @endforeach
                <p style="color:#78350f; font-size:0.78rem; margin:0.4rem 0 0 0;">
                    Silakan edit file Word agar setiap data memiliki nama yang berbeda, lalu upload ulang.
                </p>
            @endif

            @if ($hasMalformed)
                <p style="color:#78350f; font-size:0.82rem; margin:{{ $hasDuplicates ? '0.6rem' : '0' }} 0 0.4rem 0; font-weight:600;">Data tidak terbaca (kemungkinan typo):</p>
                @foreach ($analysis['malformed'] as $item)
                    <div style="display:flex; align-items:center; gap:0.4rem; margin-bottom:0.2rem; font-size:0.82rem;">
                        <span style="color:#ef4444;">✗</span>
                        <code style="background:#fee2e2; padding:0.1rem 0.4rem; border-radius:0.2rem; color:#991b1b;">{{ $item }}</code>
                        <span style="color:#78350f;">bracket tidak lengkap</span>
                    </div>
                @endforeach
            @endif
        </div>
    @endif

    {{-- Daftar placeholder --}}
    @if ($validCount > 0 || $hasDuplicates)
        <div style="display:flex; flex-direction:column; gap:0.2rem; margin-bottom:0.75rem;">
            @foreach ($analysis['valid'] as $placeholder)
                <div style="display:flex; align-items:center; gap:0.4rem; font-size:0.875rem;">
                    <span style="color:#22c55e;">✓</span>
                    <span style="font-family:monospace; color:#1e293b;">{{ $placeholder }}</span>
                </div>
            @endforeach
            @foreach ($analysis['duplicates'] as $key => $count)
                <div style="display:flex; align-items:center; gap:0.4rem; font-size:0.875rem;">
                    <span style="color:#f59e0b;">⚠</span>
                    <span style="font-family:monospace; color:#92400e;">{{ $key }}</span>
                    <span style="font-size:0.75rem; color:#94a3b8;">— {{ $count }} kali</span>
                </div>
            @endforeach
        </div>
    @else
        <p style="color:#94a3b8; font-size:0.85rem; margin:0 0 0.75rem 0;">
            Tidak ada data placeholder ditemukan dalam template ini.
        </p>
    @endif

    {{-- Status keseluruhan --}}
    @if ($hasIssues)
        <div style="padding:0.5rem 0.875rem; background:#fef3c7; border:1px solid #fcd34d; border-radius:0.375rem; font-size:0.82rem; color:#92400e; font-weight:600;">
            ⚠ Template perlu diperbaiki — {{ $totalUnique }} data ditemukan
        </div>
    @else
        <div style="padding:0.5rem 0.875rem; background:#dcfce7; border:1px solid #86efac; border-radius:0.375rem; font-size:0.82rem; color:#166534; font-weight:600;">
            ✓ {{ $validCount }} data ditemukan — Template siap digunakan
        </div>
    @endif
@else
    <p style="color:#94a3b8; font-size:0.85rem; margin:0;">Belum ada file yang diupload.</p>
@endif
