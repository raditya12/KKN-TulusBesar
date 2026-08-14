<x-filament-widgets::widget>
    <x-filament::section>
        <div
            style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;"
        >
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="display:flex;align-items:center;justify-content:center;width:3.5rem;height:3.5rem;border-radius:1rem;background:linear-gradient(135deg,#8C5A35,#4A2B1D);box-shadow:0 4px 10px rgba(140,90,53,.3);color:white;flex-shrink:0;">
                    <x-heroicon-o-rocket-launch style="width:1.75rem;height:1.75rem;" />
                </div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white" style="margin:0;">
                        Panduan Sistem
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400" style="margin:0.25rem 0 0;max-width:42rem;line-height:1.5;">
                        Pelajari alur penggunaan sistem pengarsipan surat dan pendataan warga secara mudah dan interaktif.
                    </p>
                </div>
            </div>
            <div style="flex-shrink:0; display:flex; align-items:center; gap:0.5rem;">
                <x-filament::button color="primary" tag="button" type="button" icon="heroicon-m-play" onclick="window.startSystemTour()">
                    Mulai Panduan
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
