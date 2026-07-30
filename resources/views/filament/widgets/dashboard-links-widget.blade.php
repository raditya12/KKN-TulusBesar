<x-filament-widgets::widget>
    <style>
        .custom-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }
        .custom-card {
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(140, 90, 53, 0.2);
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .custom-card {
            background: rgba(30, 20, 15, 0.6);
            border: 1px solid rgba(140, 90, 53, 0.3);
        }
        .custom-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px -5px rgba(74, 43, 29, 0.2);
            border-color: rgba(140, 90, 53, 0.5);
        }
        .custom-icon-wrapper {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border-radius: 0.75rem;
            background: rgba(140, 90, 53, 0.1);
            color: #8C5A35;
            width: fit-content;
        }
        .custom-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }
        .dark .custom-title {
            color: #f3f4f6;
        }
        .custom-desc {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        .dark .custom-desc {
            color: #9ca3af;
        }
        .custom-action {
            margin-top: auto;
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 500;
            color: #8C5A35;
        }
    </style>

    <x-filament::section>
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">Akses Cepat Pengelolaan Data</h2>
            <p style="font-size: 0.875rem; color: #6b7280;">Pilih menu di bawah ini untuk mengelola konten website Desa Tulusbesar.</p>
        </div>

        <div class="custom-grid">
            @foreach($links as $link)
                <a href="{{ $link['url'] }}" class="custom-card">
                    <div class="custom-icon-wrapper">
                        <x-filament::icon
                            :icon="$link['icon']"
                            style="height: 2rem; width: 2rem;"
                        />
                    </div>
                    
                    <h3 class="custom-title">{{ $link['name'] }}</h3>
                    <p class="custom-desc">{{ $link['description'] }}</p>
                    
                    <div class="custom-action">
                        <span>Kelola Sekarang</span>
                        <x-filament::icon
                            icon="heroicon-m-arrow-right"
                            style="height: 1rem; width: 1rem; margin-left: 0.25rem;"
                        />
                    </div>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
