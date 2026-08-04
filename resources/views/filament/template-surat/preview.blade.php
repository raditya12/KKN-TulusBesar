<x-filament-panels::page>
    @php
        $placeholderService = app(\App\Services\Surat\PlaceholderService::class);
        $placeholders = $placeholderService->extractPlaceholders($konten);
        $registeredPlaceholders = \App\Models\MasterPlaceholder::pluck('placeholder')->toArray();
        $validPlaceholders = array_intersect($placeholders, $registeredPlaceholders);
        $invalidPlaceholders = array_diff($placeholders, $registeredPlaceholders);
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Header Info Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 sm:p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-slate-100">
                    {{ $template->judul }}
                </h2>
                <div class="mt-2 flex items-center gap-3 flex-wrap">
                    <x-filament::badge color="info">
                        {{ $template->jenisSurat->nama ?? 'Template' }}
                    </x-filament::badge>

                    @if($template->is_active)
                        <x-filament::badge color="success">Aktif</x-filament::badge>
                    @else
                        <x-filament::badge color="gray">Tidak Aktif</x-filament::badge>
                    @endif

                    <span class="text-xs text-slate-500 dark:text-slate-400">
                        Terakhir diperbarui: {{ $template->updated_at->format('d M Y H:i') }}
                    </span>
                </div>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-2">
                <a href="{{ route('filament.admin.resources.template-surat.edit', $template) }}" 
                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs font-semibold bg-primary-600 hover:bg-primary-500 text-white transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Template
                </a>
            </div>
        </div>

        <!-- Placeholder Analysis Bar -->
        <div class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl p-4 shadow-sm">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2 text-sm font-semibold text-slate-800 dark:text-slate-200">
                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Daftar Variable / Placeholder Terdaftar
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-slate-200 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                        Total: {{ count($placeholders) }}
                    </span>
                    <span class="px-2 py-0.5 rounded text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                        ✓ Valid: {{ count($validPlaceholders) }}
                    </span>
                    @if(count($invalidPlaceholders) > 0)
                        <span class="px-2 py-0.5 rounded text-xs font-medium bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">
                            ⚠ Tidak Valid: {{ count($invalidPlaceholders) }}
                        </span>
                    @endif
                </div>
            </div>

            @if(count($placeholders) > 0)
                <div class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-800 flex flex-wrap gap-1.5">
                    @foreach($placeholders as $ph)
                        @php $isValid = in_array($ph, $registeredPlaceholders); @endphp
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded text-xs font-mono font-medium {{ $isValid ? 'bg-emerald-50 text-emerald-700 border border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800' : 'bg-rose-50 text-rose-700 border border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-800' }}">
                            {{ $isValid ? '✓' : '✕' }} {{ $ph }}
                        </span>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- A4 Paper View Container -->
        <div class="bg-slate-200/70 dark:bg-slate-950 border border-slate-300 dark:border-slate-800 rounded-xl p-6 sm:p-10 flex justify-center shadow-inner overflow-x-auto">
            <div class="w-full max-w-[210mm] min-h-[297mm] bg-white text-black p-[20mm_25mm] shadow-2xl border border-slate-300 rounded-sm"
                 style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6;">
                {!! $konten !!}
            </div>
        </div>

        <div class="p-4 bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-900/50 rounded-xl text-sm text-amber-800 dark:text-amber-300 flex items-start gap-3">
            <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <strong>Catatan Sistem:</strong> Variabel seperti <code>&#123;&#123;nama&#125;&#125;</code>, <code>&#123;&#123;nik&#125;&#125;</code>, dan <code>&#123;&#123;nomor_surat&#125;&#125;</code> akan digantikan secara otomatis dengan data aktual warga saat surat diterbitkan melalui Layanan Pembuatan Surat.
            </div>
        </div>
    </div>
</x-filament-panels::page>
