@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar">
    
    @php
        $slideImages = $umkms
            ->filter(fn($u) => !empty($u->image_path))
            ->map(fn($u) => Str::startsWith($u->image_path, 'images/dummy/')
                ? asset($u->image_path)
                : \Illuminate\Support\Facades\Storage::disk('public')->url($u->image_path)
            )
            ->values()
            ->toArray();
        if (empty($slideImages)) {
            $slideImages = [
                asset('images/dummy/umkm1.jpg'),
            ];
        }
    @endphp

    <!-- Hero Section -->
    <section
        class="relative pt-24 md:pt-32 pb-16 md:pb-24 bg-surface-container-low overflow-hidden"
        x-data="{
            slides: {{ json_encode($slideImages) }},
            current: 0,
            timer: null,
            init() {
                this.timer = setInterval(() => {
                    this.current = (this.current + 1) % this.slides.length;
                }, 4500);
            },
            destroy() { clearInterval(this.timer); }
        }"
        x-init="init()"
    >
        <!-- Slideshow Background -->
        <div class="absolute inset-0 z-0">
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                    :style="{ opacity: current === index ? '1' : '0' }"
                >
                    <img
                        :src="slide"
                        alt="Foto UMKM Desa"
                        class="w-full h-full object-cover opacity-60 filter contrast-110"
                    >
                </div>
            </template>
            <!-- Gradient overlay -->
            <div class="absolute inset-0 bg-gradient-to-b from-surface-container-low/30 via-surface-container-low/50 to-surface-container-low z-10"></div>
        </div>

        <!-- Slide Indicators -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button
                    @click="current = index; clearInterval(timer); timer = setInterval(() => { current = (current + 1) % slides.length; }, 4500);"
                    class="transition-all duration-300 rounded-full"
                    :class="current === index ? 'w-6 h-2.5 bg-primary' : 'w-2.5 h-2.5 bg-surface-container/60 hover:bg-primary/60'"
                ></button>
            </template>
        </div>
        
        <div class="max-w-screen-xl mx-auto px-container-margin relative z-10 text-center transition-all duration-1000 ease-out transform" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
            <span class="inline-block font-label-md text-primary bg-primary/10 border border-primary/20 px-4 py-2 rounded-full tracking-widest uppercase mb-6 shadow-sm">
                Roda Ekonomi Desa
            </span>
            <h1 class="font-display-lg text-4xl md:text-6xl font-bold text-on-background mb-6 max-w-[56rem] mx-auto leading-tight">
                Potensi UMKM & <br><span class="text-secondary">Ekonomi Kreatif</span>
            </h1>
            <p class="font-body-md text-on-surface-variant text-lg max-w-[48rem] mx-auto leading-relaxed shadow-sm">
                Keuletan tangan warga Tulusbesar menggerakkan ekonomi kerakyatan melalui berbagai kerajinan kriya, pertanian berkelanjutan, hingga industri pangan.
            </p>
        </div>
    </section>

    <!-- Katalog UMKM (CMS Ready Grid) -->
    <section class="py-16 md:py-24 bg-background">
        <div class="max-w-screen-xl mx-auto px-container-margin transition-all duration-1000 ease-out transform" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-12'">
            
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-12 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[24px]">storefront</span>
                </div>
                <div>
                    <h2 class="font-display-md text-3xl font-bold text-on-background">Katalog <span class="text-secondary">UMKM & Produk</span></h2>
                    <p class="font-body-sm text-on-surface-variant mt-1">Daftar lengkap potensi usaha masyarakat yang siap diintegrasikan dengan sistem CMS.</p>
                </div>
            </div>

            <!-- GRID KATALOG (CMS Loop) -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                @foreach($umkms as $umkm)
                <!-- UMKM Item -->
                <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 border border-outline-variant/30 flex flex-col group">
                    <div class="h-56 relative overflow-hidden">
                        <div class="absolute inset-0 bg-primary/20 group-hover:bg-transparent transition-colors duration-500 z-10 mix-blend-multiply"></div>
                        <img src="{{ empty($umkm->image_path) ? asset('images/dummy/umkm1.jpg') : (Str::startsWith($umkm->image_path, 'images/dummy/') ? asset($umkm->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($umkm->image_path)) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 sepia-[0.2]">
                    </div>
                    <div class="p-6 flex-grow flex flex-col">
                        <div class="font-label-sm text-secondary uppercase tracking-widest mb-2">{{ $umkm->category }}</div>
                        <h3 class="font-headline-md text-2xl font-bold text-on-surface mb-3 group-hover:text-primary transition-colors">{{ $umkm->name }}</h3>
                        {{-- Description: render HTML langsung agar format editor (baris, paragraf) terjaga --}}
                        <div class="font-body-sm text-on-surface-variant text-left line-clamp-4 flex-grow mb-4 break-words min-w-0 card-desc-preview">{!! $umkm->description !!}</div>

                        <a href="{{ route('umkm.show', $umkm->slug) }}" class="w-full bg-surface-container hover:bg-primary text-primary hover:text-on-primary font-label-sm py-2 rounded-xl transition-colors border border-outline-variant/50 hover:border-primary flex items-center justify-center gap-2 mt-auto">
                            Selengkapnya <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @endforeach

            </div> <!-- END GRID -->
            
        </div>
    </section>

    <!-- Footer Include -->
    <x-footer />
</div>
@endsection
