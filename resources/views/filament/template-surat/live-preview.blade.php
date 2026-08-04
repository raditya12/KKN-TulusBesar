@php
    $html = $get('konten_html') ?? '';
    $placeholderService = app(\App\Services\Surat\PlaceholderService::class);
    $placeholders = $placeholderService->extractPlaceholders($html);
    $registeredPlaceholders = \App\Models\MasterPlaceholder::pluck('placeholder')->toArray();
    $validPlaceholders = array_intersect($placeholders, $registeredPlaceholders);
    $invalidPlaceholders = array_diff($placeholders, $registeredPlaceholders);
@endphp

<div class="space-y-4">
    <!-- Header Status & Placeholder Bar -->
    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/80">
        <div class="flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
            <div class="flex items-center gap-2">
                <svg width="20" height="20" style="width:20px; height:20px; flex-shrink:0;" class="text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h4 class="text-sm font-bold text-slate-800 dark:text-slate-100">
                        Analisis Variable Dokumen
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Placeholder terdeteksi otomatis dari isi template HTML.
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <span class="rounded-md bg-slate-200 px-2.5 py-1 text-xs font-semibold text-slate-700 dark:bg-slate-700 dark:text-slate-200">
                    Total: {{ count($placeholders) }}
                </span>
                <span class="rounded-md bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300">
                    ✓ Valid: {{ count($validPlaceholders) }}
                </span>
                @if(count($invalidPlaceholders) > 0)
                    <span class="rounded-md bg-rose-100 px-2.5 py-1 text-xs font-semibold text-rose-800 dark:bg-rose-950/80 dark:text-rose-300">
                        ⚠ Tidak Valid: {{ count($invalidPlaceholders) }}
                    </span>
                @endif
            </div>
        </div>

        <!-- Registered Badges List -->
        @if(count($placeholders) > 0)
            <div class="mt-3 flex flex-wrap gap-1.5 border-t border-slate-200 pt-3 dark:border-slate-700">
                @foreach($placeholders as $ph)
                    @php $isValid = in_array($ph, $registeredPlaceholders); @endphp
                    <span class="inline-flex items-center gap-1 rounded border px-2 py-0.5 font-mono text-xs font-medium {{ $isValid ? 'border-emerald-300 bg-emerald-50 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-950/40 dark:text-emerald-300' : 'border-rose-300 bg-rose-50 text-rose-700 dark:border-rose-800 dark:bg-rose-950/40 dark:text-rose-300' }}">
                        <span>{{ $isValid ? '✓' : '✕' }}</span>
                        {{ $ph }}
                    </span>
                @endforeach
            </div>
        @else
            <div class="mt-2 text-xs italic text-slate-400">
                Belum ada placeholder <code>&#123;&#123;nama_field&#125;&#125;</code> pada template ini.
            </div>
        @endif
    </div>

    <!-- Live Document Paper Card -->
    <div class="flex justify-center overflow-x-auto rounded-xl border border-slate-300 bg-slate-200/80 p-4 shadow-inner dark:border-slate-800 dark:bg-slate-950/90 sm:p-6">
        <div class="min-h-[297mm] w-full max-w-[210mm] rounded-sm border border-slate-300 bg-white p-[20mm_25mm] text-black shadow-2xl"
             style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6;">
            
            @if(trim($html))
                <div class="surat-preview-content space-y-2">
                    {!! $html !!}
                </div>
            @else
                <div class="flex h-[200mm] flex-col items-center justify-center text-center text-slate-400">
                    <svg width="48" height="48" style="width:48px; height:48px;" class="mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <p class="text-sm font-semibold text-slate-600">Pratinjau Kertas Dokumen</p>
                    <p class="mt-1 max-w-xs text-xs text-slate-400">
                        Unggah file .docx atau tuliskan isi template pada editor untuk melihat tampilan surat fisik di sini.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>
