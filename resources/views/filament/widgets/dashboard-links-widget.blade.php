<x-filament-widgets::widget>
    <style>
        .qa-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-top: 0.5rem;
        }
        @media (min-width: 640px) {
            .qa-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media (min-width: 1024px) {
            .qa-grid {
                grid-template-columns: repeat(5, 1fr);
            }
        }
        .qa-button {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.25rem 1rem;
            border-radius: 0.75rem;
            background: rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(140, 90, 53, 0.15);
            text-align: center;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
            backdrop-filter: blur(8px);
        }
        .dark .qa-button {
            background: rgba(30, 30, 30, 0.4);
            border: 1px solid rgba(140, 90, 53, 0.25);
        }
        .qa-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(140, 90, 53, 0.1);
            border-color: rgba(140, 90, 53, 0.6);
            background: rgba(140, 90, 53, 0.05);
        }
        .dark .qa-button:hover {
            background: rgba(140, 90, 53, 0.15);
        }
        .qa-icon-wrapper {
            margin-bottom: 0.75rem;
            padding: 0.6rem;
            border-radius: 9999px;
            background: rgba(140, 90, 53, 0.1);
            color: #8C5A35;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .qa-title {
            font-size: 0.95rem;
            font-weight: 600;
            color: #374151;
        }
        .dark .qa-title {
            color: #e5e7eb;
        }
    </style>

    <x-filament::section>
        <x-slot name="heading">
            Akses Cepat Administrasi Surat
        </x-slot>
        <x-slot name="description">
            Shortcut langsung menuju fitur utama pengarsipan surat
        </x-slot>

        <div class="qa-grid">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" class="qa-button">
                    <div class="qa-icon-wrapper">
                        <x-filament::icon
                            :icon="$link['icon']"
                            style="height: 1.5rem; width: 1.5rem;"
                        />
                    </div>
                    <span class="qa-title">{{ $link['name'] }}</span>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
