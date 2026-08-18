@extends('layouts.app')

@section('content')
    <div class="w-full overflow-y-auto custom-scrollbar" x-data="{ activeFilter: 'semua', lightboxOpen: false, lightboxImage: '' }" :class="lightboxOpen ? 'overflow-hidden' : ''">

        @php
            // Kumpulkan semua foto yang sudah terupload dari data situs budaya
            $slideImages = $sites
                ->filter(fn($s) => !empty($s->image_path))
                ->map(
                    fn($s) => Str::startsWith($s->image_path, 'images/dummy/')
                    ? asset($s->image_path)
                    : \Illuminate\Support\Facades\Storage::disk('public')->url($s->image_path)
                )
                ->values()
                ->toArray();
            // Fallback jika belum ada gambar terupload
            if (empty($slideImages)) {
                $slideImages = [
                    asset('images/dummy/wisata_hero.jpg'),
                    asset('images/dummy/wisata1.jpg'),
                    asset('images/dummy/tradisi1.jpg'),
                ];
            }
        @endphp

        <!-- 1. Hero Section -->
        <section class="relative pt-24 md:pt-32 pb-16 md:pb-24 bg-surface-container-low overflow-hidden" x-data="{
                slides: {{ json_encode($slideImages) }},
                current: 0,
                timer: null,
                init() {
                    this.timer = setInterval(() => {
                        this.current = (this.current + 1) % this.slides.length;
                    }, 4500);
                },
                destroy() { clearInterval(this.timer); }
            }" x-init="init()">
            <!-- Slideshow Background -->
            <div class="absolute inset-0 z-0">
                <template x-for="(slide, index) in slides" :key="index">
                    <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                        :style="{ opacity: current === index ? '1' : '0' }">
                        <img :src="slide" alt="Foto Wisata Budaya Desa"
                            class="w-full h-full object-cover opacity-60 filter contrast-110">
                    </div>
                </template>
                <!-- Gradient overlay -->
                <div
                    class="absolute inset-0 bg-gradient-to-b from-surface-container-low/30 via-surface-container-low/50 to-surface-container-low z-10">
                </div>
            </div>

            <!-- Slide Indicators -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2">
                <template x-for="(slide, index) in slides" :key="index">
                    <button
                        @click="current = index; clearInterval(timer); timer = setInterval(() => { current = (current + 1) % slides.length; }, 4500);"
                        class="transition-all duration-300 rounded-full"
                        :class="current === index ? 'w-6 h-2.5 bg-tertiary' : 'w-2.5 h-2.5 bg-surface-container/60 hover:bg-tertiary/60'"></button>
                </template>
            </div>

            <!-- Abstract Javanese Pattern -->
            <div class="absolute inset-0 opacity-[0.03] z-0 pointer-events-none"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%234a2b1d\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>

            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10 text-center">
                <span
                    class="inline-block font-label-md text-tertiary bg-tertiary/10 border border-tertiary/20 px-4 py-2 rounded-full tracking-widest uppercase mb-6 shadow-sm">
                    Eksplorasi Desa
                </span>
                <h1
                    class="font-display-lg text-4xl md:text-6xl font-bold text-on-background mb-6 max-w-[56rem] mx-auto leading-tight">
                    Pesona Jejak Leluhur dan <br><span class="text-secondary">Kearifan Lokal Tulusbesar</span>
                </h1>
                <p class="font-body-md text-on-surface-variant text-lg max-w-[48rem] mx-auto leading-relaxed shadow-sm">
                    Jelajahi kekayaan pusaka sejarah, harmoni tradisi Jawa yang masih kental, serta inovasi UMKM yang
                    menjadi denyut nadi perekonomian masyarakat Desa Tulusbesar.
                </p>
            </div>
        </section>

        <!-- Highlight: Paket Wisata 3D Booklet -->
        <section class="py-16 md:py-24 bg-surface-container-lowest relative overflow-hidden border-b border-outline-variant/30" x-show="activeFilter === 'semua'" x-transition>
            <!-- Decorative elements -->
            <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-tertiary/10 rounded-full blur-[100px] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-secondary/10 rounded-full blur-[100px] translate-y-1/3 -translate-x-1/3 pointer-events-none"></div>
            
            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10">
                <div class="text-center mb-10 md:mb-16">
                    <span class="inline-block font-label-md text-primary bg-primary/10 border border-primary/20 px-4 py-1.5 rounded-full tracking-widest uppercase mb-4 shadow-sm">
                        Penawaran Spesial
                    </span>
                    <h2 class="font-display-md text-3xl md:text-5xl font-bold text-on-background mb-6">
                        Paket Wisata <span class="text-primary">Tulusbesar</span>
                    </h2>
                    <p class="font-body-md text-on-surface-variant text-lg max-w-[48rem] mx-auto leading-relaxed">
                        Rasakan pengalaman otentik berbaur dengan budaya, seni, dan sejarah secara langsung. Pilih paket wisata eksklusif kami dan ciptakan perjalanan tak terlupakan!
                    </p>
                </div>

                <!-- 3D Booklet Layout -->
                <div class="flex flex-col lg:flex-row items-center justify-center gap-6 lg:gap-0 [perspective:2500px]">
                    <!-- Page 1 (Left) -->
                    <div @click="lightboxOpen = true; lightboxImage = '{{ asset('images/paket-wisata/paket1.jpg') }}'" class="cursor-pointer group relative w-full max-w-[600px] lg:max-w-[650px] transition-all duration-700 ease-out lg:[transform:rotateY(10deg)] lg:origin-right lg:hover:[transform:rotateY(0deg)_scale(1.03)] lg:hover:z-20 shadow-xl hover:shadow-2xl rounded-2xl lg:rounded-l-2xl lg:rounded-r-none overflow-hidden border-4 md:border-8 border-white bg-white">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="material-symbols-outlined text-white text-[64px] drop-shadow-xl">zoom_in</span>
                        </div>
                        <img src="{{ asset('images/paket-wisata/paket1.jpg') }}" alt="Brosur Paket Wisata Halaman 1" class="w-full h-auto object-cover">
                    </div>
                    
                    <!-- Page 2 (Right) -->
                    <div @click="lightboxOpen = true; lightboxImage = '{{ asset('images/paket-wisata/paket2.jpg') }}'" class="cursor-pointer group relative w-full max-w-[600px] lg:max-w-[650px] transition-all duration-700 ease-out lg:[transform:rotateY(-10deg)] lg:origin-left lg:hover:[transform:rotateY(0deg)_scale(1.03)] lg:hover:z-20 shadow-xl hover:shadow-2xl rounded-2xl lg:rounded-r-2xl lg:rounded-l-none overflow-hidden border-4 md:border-8 border-white bg-white">
                        <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="material-symbols-outlined text-white text-[64px] drop-shadow-xl">zoom_in</span>
                        </div>
                        <img src="{{ asset('images/paket-wisata/paket2.jpg') }}" alt="Brosur Paket Wisata Halaman 2" class="w-full h-auto object-cover">
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="mt-12 md:mt-16 flex justify-center">
                    <a href="https://wa.me/6281225826217" target="_blank" rel="noopener noreferrer" 
                       class="group relative inline-flex items-center justify-center gap-3 bg-primary hover:bg-primary-fixed-dim text-on-primary font-label-lg px-10 py-5 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgba(var(--color-primary),0.3)] transition-all duration-300 transform hover:-translate-y-1 overflow-hidden">
                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                        <span class="material-symbols-outlined relative z-10 text-[24px]">support_agent</span>
                        <span class="relative z-10 font-bold tracking-wide">Hubungi Kami Sekarang</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- Navigation / Filter Bar -->
        @php
            $customCategories = $sites->pluck('category')->unique()->filter(fn($c) => !in_array($c, ['sejarah', 'budaya']));
        @endphp
        <div class="bg-surface-container-lowest border-b border-outline-variant/30 sticky top-0 z-40 shadow-sm">
            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin py-4">
                <div
                    class="flex overflow-x-auto custom-scrollbar gap-2 md:gap-4 md:justify-center items-center pb-2 md:pb-0">
                    <button @click="activeFilter = 'semua'"
                        class="px-6 py-2 rounded-full font-label-md transition-all shrink-0 whitespace-nowrap"
                        :class="activeFilter === 'semua' ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container border border-outline-variant/50 text-on-surface-variant hover:bg-surface-variant'">
                        Semua Kategori
                    </button>
                    <button @click="activeFilter = 'sejarah'"
                        class="px-6 py-2 rounded-full font-label-md transition-all shrink-0 whitespace-nowrap"
                        :class="activeFilter === 'sejarah' ? 'bg-secondary text-on-primary shadow-md' : 'bg-surface-container border border-outline-variant/50 text-on-surface-variant hover:bg-surface-variant'">
                        Sejarah & Religi
                    </button>
                    <button @click="activeFilter = 'budaya'"
                        class="px-6 py-2 rounded-full font-label-md transition-all shrink-0 whitespace-nowrap"
                        :class="activeFilter === 'budaya' ? 'bg-tertiary text-on-primary shadow-md' : 'bg-surface-container border border-outline-variant/50 text-on-surface-variant hover:bg-surface-variant'">
                        Seni & Tradisi
                    </button>
                    @foreach($customCategories as $cat)
                        @php $catSlug = Str::slug($cat); @endphp
                        <button @click="activeFilter = '{{ $catSlug }}'"
                            class="px-6 py-2 rounded-full font-label-md transition-all shrink-0 whitespace-nowrap"
                            :class="activeFilter === '{{ $catSlug }}' ? 'bg-primary text-on-primary shadow-md' : 'bg-surface-container border border-outline-variant/50 text-on-surface-variant hover:bg-surface-variant'">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- 2. Wisata Sejarah & Religi (Situs Punden & Petilasan) -->
        <section x-show="activeFilter === 'semua' || activeFilter === 'sejarah'" x-transition.opacity.duration.500ms
            class="py-16 md:py-24 bg-background">
            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">

                <div class="flex items-center gap-4 mb-12">
                    <div
                        class="w-12 h-12 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[24px]">account_balance</span>
                    </div>
                    <div>
                        <h2 class="font-display-md text-3xl font-bold text-on-background">Situs Punden & <span
                                class="text-secondary">Petilasan</span></h2>
                        <p class="font-body-sm text-on-surface-variant mt-1">Jelajahi nilai historis tinggi dari jejak para
                            nenek moyang pembabat alas desa.</p>
                    </div>
                </div>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    @foreach($sites->where('category', 'sejarah') as $site)
                        <!-- Card -->
                        <div
                            class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm border border-outline-variant/30 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative">


                            <div class="relative h-64 overflow-hidden">
                                <div
                                    class="absolute inset-0 bg-primary/20 group-hover:bg-transparent transition-colors duration-500 z-10 mix-blend-multiply">
                                </div>
                                <img src="{{ empty($site->image_path) ? asset('images/dummy/wisata1.jpg') : (Str::startsWith($site->image_path, 'images/dummy/') ? asset($site->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($site->image_path)) }}"
                                    alt="{{ $site->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 sepia-[0.3]">
                            </div>

                            <div
                                class="p-6 md:p-8 flex-grow flex flex-col bg-surface-container-lowest relative z-20 -mt-6 mx-4 rounded-2xl border border-outline-variant/20 shadow-md">
                                <h3 class="font-headline-md text-xl font-bold text-on-surface mb-2">{{ $site->name }}</h3>
                                @if(!empty($site->latitude) && !empty($site->longitude))
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $site->latitude }},{{ $site->longitude }}" target="_blank" 
                                       class="inline-flex items-center gap-1 text-secondary hover:text-secondary-fixed-dim font-label-sm mb-4 hover:underline w-fit transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">directions</span> Rute Lokasi
                                    </a>
                                @endif
                                <div class="font-body-sm text-on-surface-variant line-clamp-4 mb-4 break-words min-w-0 card-desc-preview">{!! $site->description !!}</div>
                                <a href="{{ route('wisata.show', $site->slug) }}"
                                    class="w-full mt-auto bg-primary/5 hover:bg-primary text-primary hover:text-on-primary font-label-md py-3 rounded-xl transition-colors border border-primary/20 hover:border-primary flex items-center justify-center gap-2">
                                    Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- 3. Tradisi & Seni Budaya (Kearifan Lokal) - Zig-Zag Layout -->
        <section x-show="activeFilter === 'semua' || activeFilter === 'budaya'" x-transition.opacity.duration.500ms
            class="py-16 md:py-24 bg-surface-container-low overflow-hidden">
            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">

                <div class="text-center max-w-[48rem] mx-auto mb-16">
                    <h2 class="font-display-md text-3xl md:text-4xl font-bold text-on-background mb-4">Tradisi & <span
                            class="text-tertiary">Seni Budaya</span></h2>
                    <p class="font-body-md text-on-surface-variant text-lg">
                        Kehidupan masyarakat yang harmonis dibalut dengan pelestarian tradisi asli Javanese yang telah
                        diwariskan turun-temurun.
                    </p>
                </div>

                <div class="space-y-16 md:space-y-24">
                    @forelse($sites->where('category', 'budaya') as $index => $site)
                        <!-- Zig-zag Item -->
                        <div
                            class="flex flex-col {{ $loop->even ? 'md:flex-row-reverse' : 'md:flex-row' }} items-center gap-8 md:gap-16">
                            <div class="w-full md:w-1/2">
                                <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                                    <div
                                        class="absolute inset-0 {{ $loop->even ? 'bg-secondary/10' : 'bg-tertiary/10' }} group-hover:bg-transparent transition-colors duration-500 z-10">
                                    </div>
                                    <img src="{{ empty($site->image_path) ? asset('images/dummy/tradisi1.jpg') : (Str::startsWith($site->image_path, 'images/dummy/') ? asset($site->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($site->image_path)) }}"
                                        alt="{{ $site->name }}"
                                        class="w-full h-[300px] md:h-[400px] object-cover transform transition-transform duration-700 group-hover:scale-105">

                                    <div
                                        class="absolute bottom-6 {{ $loop->even ? 'right-6' : 'left-6' }} z-20 bg-surface-container-lowest p-4 rounded-2xl shadow-lg border border-outline-variant/30 flex items-center gap-4">
                                        @if($loop->even)
                                            <div class="text-right">
                                                <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Seni &
                                                    Budaya</div>
                                                <div class="font-headline-md font-bold text-on-surface">Kearifan Lokal</div>
                                            </div>
                                            <div
                                                class="w-12 h-12 bg-secondary/10 text-secondary rounded-full flex items-center justify-center">
                                                <span class="material-symbols-outlined">theater_comedy</span>
                                            </div>
                                        @else
                                            <div
                                                class="w-12 h-12 bg-tertiary/10 text-tertiary rounded-full flex items-center justify-center">
                                                <span class="material-symbols-outlined">celebration</span>
                                            </div>
                                            <div>
                                                <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Seni &
                                                    Budaya</div>
                                                <div class="font-headline-md font-bold text-on-surface">Kearifan Lokal</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-1/2 space-y-4">
                                <h3
                                    class="font-display-md text-3xl font-bold text-on-background {{ $loop->even ? 'text-secondary' : 'text-tertiary' }}">
                                    {{ $site->name }}</h3>
                                <div class="font-body-md text-on-surface-variant text-lg leading-relaxed text-left line-clamp-4 break-words min-w-0 card-desc-preview">{!! $site->description !!}</div>
                                <a href="{{ route('wisata.show', $site->slug) }}"
                                    class="inline-flex items-center gap-2 mt-4 font-label-md text-primary hover:text-primary-fixed-dim transition-colors">
                                    Baca Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 text-on-surface-variant font-body-md">
                            Belum ada data Seni & Tradisi yang ditambahkan.
                        </div>
                    @endforelse
                </div>
            </div>
        </section>


        <!-- 4. Dynamic Categories (Custom Categories) -->
        @foreach($customCategories as $cat)
            @php $catSlug = Str::slug($cat); @endphp
            <section x-show="activeFilter === 'semua' || activeFilter === '{{ $catSlug }}'" x-transition.opacity.duration.500ms
                class="py-16 md:py-24 bg-background border-t border-outline-variant/20">
                <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">

                    <div class="flex items-center gap-4 mb-12">
                        <div
                            class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[24px]">explore</span>
                        </div>
                        <div>
                            <h2 class="font-display-md text-3xl font-bold text-on-background">{{ $cat }}</h2>
                            <p class="font-body-sm text-on-surface-variant mt-1">Eksplorasi destinasi dan kekayaan desa untuk
                                kategori {{ $cat }}.</p>
                        </div>
                    </div>

                    <!-- Grid Cards -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        @forelse($sites->where('category', $cat) as $site)
                            <!-- Card -->
                            <div
                                class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm border border-outline-variant/30 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative">
                                <div class="relative h-64 overflow-hidden">
                                    <div
                                        class="absolute inset-0 bg-primary/20 group-hover:bg-transparent transition-colors duration-500 z-10 mix-blend-multiply">
                                    </div>
                                    <img src="{{ empty($site->image_path) ? asset('images/dummy/wisata1.jpg') : (Str::startsWith($site->image_path, 'images/dummy/') ? asset($site->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($site->image_path)) }}"
                                        alt="{{ $site->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 sepia-[0.3]">
                                </div>

                                <div
                                    class="p-6 md:p-8 flex-grow flex flex-col bg-surface-container-lowest relative z-20 -mt-6 mx-4 rounded-2xl border border-outline-variant/20 shadow-md">
                                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-2">{{ $site->name }}</h3>
                                    @if(!empty($site->latitude) && !empty($site->longitude))
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $site->latitude }},{{ $site->longitude }}" target="_blank" 
                                           class="inline-flex items-center gap-1 text-secondary hover:text-secondary-fixed-dim font-label-sm mb-4 hover:underline w-fit transition-colors">
                                            <span class="material-symbols-outlined text-[16px]">directions</span> Rute Lokasi
                                        </a>
                                    @endif
                                    <div class="font-body-sm text-on-surface-variant line-clamp-4 mb-4 break-words min-w-0 card-desc-preview">{!! $site->description !!}</div>
                                    <a href="{{ route('wisata.show', $site->slug) }}"
                                        class="w-full mt-auto bg-primary/5 hover:bg-primary text-primary hover:text-on-primary font-label-md py-3 rounded-xl transition-colors border border-primary/20 hover:border-primary flex items-center justify-center gap-2">
                                        Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8 text-on-surface-variant font-body-md">
                                Belum ada data untuk kategori ini.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        @endforeach

        <!-- 5. CTA (Call-to-Action) ke WebGIS -->
        <section class="py-16 md:py-20 bg-primary relative overflow-hidden">
            <!-- Abstract Decoration -->
            <div
                class="absolute right-0 top-0 w-2/3 h-full bg-gradient-to-l from-secondary/40 to-transparent pointer-events-none">
            </div>
            <div class="absolute inset-0 opacity-10 pointer-events-none"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');">
            </div>

            <span
                class="material-symbols-outlined absolute -left-10 -bottom-10 text-[250px] text-white/5 pointer-events-none">map</span>

            <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10">
                <div
                    class="bg-surface-container-lowest/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12 shadow-2xl">
                    <div class="md:w-2/3 text-on-primary text-center md:text-left">
                        <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                            <span class="material-symbols-outlined bg-white/20 p-2 rounded-xl">pin_drop</span>
                            <span class="font-label-md font-bold tracking-widest uppercase text-white/80">Sistem Informasi
                                Geografis</span>
                        </div>
                        <h2 class="font-display-md text-3xl md:text-4xl font-bold mb-4 leading-tight">
                            Ingin melihat langsung rute ke Situs Punden, Sentra Industri Tahu, atau Fasilitas Umum kami?
                        </h2>
                        <p class="font-body-md text-lg text-white/90">
                            Akses peta pintar (WebGIS) kami untuk menemukan berbagai titik lokasi di Desa Tulusbesar dengan
                            mudah.
                        </p>
                    </div>
                    <div class="md:w-1/3 flex justify-center md:justify-end shrink-0 w-full md:w-auto">
                        <a href="{{ route('peta') }}"
                            class="w-full md:w-auto bg-tertiary-fixed hover:bg-white text-on-tertiary-fixed font-label-md px-8 py-5 rounded-xl shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg font-bold group">
                            <span
                                class="material-symbols-outlined group-hover:scale-110 transition-transform">explore</span>
                            Buka Peta WebGIS Desa
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <x-footer />

        <!-- Lightbox Modal -->
        <template x-teleport="body">
            <div x-show="lightboxOpen" style="display: none;"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="fixed inset-0 z-[99999] bg-black bg-opacity-95 flex flex-col" style="transform: translateZ(9999px);">
                 
                <!-- Close Button -->
                <button @click="lightboxOpen = false" class="absolute top-4 right-4 md:top-8 md:right-8 w-12 h-12 bg-black/50 hover:bg-white/20 rounded-full flex items-center justify-center text-white transition-colors z-50 shadow-lg border border-white/20">
                    <span class="material-symbols-outlined text-[32px]">close</span>
                </button>
                
                <!-- Scrollable Image Container for Mobile Panning -->
                <div class="w-full h-full overflow-auto flex items-center justify-center p-4 md:p-8">
                    <!-- Image is wider on mobile (min-w-[150%]) to allow panning and reading text clearly -->
                    <img :src="lightboxImage" alt="Zoomed View" 
                         class="min-w-[150%] md:min-w-0 max-w-none md:max-w-full h-auto md:max-h-[90vh] object-contain rounded-xl shadow-[0_0_50px_rgba(0,0,0,0.5)] border border-white/10" 
                         @click.away="lightboxOpen = false">
                </div>
            </div>
        </template>
    </div>
@endsection