<x-filament-panels::page>
    <div class="max-w-4xl mx-auto">
        <div class="mb-4 flex items-center gap-3">
            <x-filament::badge color="info">
                {{ $template->jenisSurat->nama ?? 'Template' }}
            </x-filament::badge>

            @if($template->is_active)
                <x-filament::badge color="success">Aktif</x-filament::badge>
            @else
                <x-filament::badge color="gray">Tidak Aktif</x-filament::badge>
            @endif

            <span class="text-sm text-gray-500">
                Terakhir diperbarui: {{ $template->updated_at->format('d M Y H:i') }}
            </span>
        </div>

        <x-filament::section>
            <x-slot name="heading">{{ $template->judul }}</x-slot>

            <div
                class="bg-white border border-gray-200 rounded-lg p-8 min-h-[500px]"
                style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.6; color: #000;"
            >
                {!! $konten !!}
            </div>
        </x-filament::section>

        <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-700">
            <strong>Catatan:</strong> Placeholder seperti <code>{{nama}}</code> akan diganti dengan data warga saat surat dibuat.
        </div>
    </div>
</x-filament-panels::page>
