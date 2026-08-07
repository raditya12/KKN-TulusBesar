<x-filament-widgets::widget>
    @if(!empty($links))
    <x-filament::section>
        <x-slot name="heading">
            Akses Cepat
        </x-slot>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 1rem;">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 1.25rem 1rem; border-radius: 0.75rem; background: rgba(255,255,255,0.4); border: 1px solid rgba(140,90,53,0.15); text-align: center; text-decoration: none; transition: all 0.2s;">
                    <div style="margin-bottom: 0.75rem; padding: 0.6rem; border-radius: 9999px; background: rgba(140,90,53,0.1); color: #8C5A35; display: inline-flex;">
                        <x-filament::icon :icon="$link['icon']" style="height: 1.5rem; width: 1.5rem;" />
                    </div>
                    <span style="font-size: 0.875rem; font-weight: 600;">{{ $link['name'] }}</span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
    @endif
</x-filament-widgets::widget>
