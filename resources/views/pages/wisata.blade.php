@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar" x-data="{ activeFilter: 'semua' }">
    
    @php
        // Kumpulkan semua foto yang sudah terupload dari data situs budaya
        $slideImages = $sites
            ->filter(fn($s) => !empty($s->image_path))
            ->map(fn($s) => Str::startsWith($s->image_path, 'images/dummy/')
                ? asset($s->image_path)
                : asset('storage/' . $s->image_path)
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
                        alt="Foto Wisata Budaya Desa"
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
                    :class="current === index ? 'w-6 h-2.5 bg-tertiary' : 'w-2.5 h-2.5 bg-surface-container/60 hover:bg-tertiary/60'"
                ></button>
            </template>
        </div>
        
        <!-- Abstract Javanese Pattern -->
        <div class="absolute inset-0 opacity-[0.03] z-0 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%234a2b1d\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10 text-center">
            <span class="inline-block font-label-md text-tertiary bg-tertiary/10 border border-tertiary/20 px-4 py-2 rounded-full tracking-widest uppercase mb-6 shadow-sm">
                Eksplorasi Desa
            </span>
            <h1 class="font-display-lg text-4xl md:text-6xl font-bold text-on-background mb-6 max-w-[56rem] mx-auto leading-tight">
                Pesona Jejak Leluhur dan <br><span class="text-secondary">Kearifan Lokal Tulusbesar</span>
            </h1>
            <p class="font-body-md text-on-surface-variant text-lg max-w-[48rem] mx-auto leading-relaxed shadow-sm">
                Jelajahi kekayaan pusaka sejarah, harmoni tradisi Jawa yang masih kental, serta inovasi UMKM yang menjadi denyut nadi perekonomian masyarakat Desa Tulusbesar.
            </p>
        </div>
    </section>

    <!-- Navigation / Filter Bar -->
    <div class="bg-surface-container-lowest border-b border-outline-variant/30 sticky top-0 z-40 shadow-sm">
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin py-4">
            <div class="flex overflow-x-auto custom-scrollbar gap-2 md:gap-4 md:justify-center items-center pb-2 md:pb-0">
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
            </div>
        </div>
    </div>

    <!-- 2. Wisata Sejarah & Religi (Situs Punden & Petilasan) -->
    <section x-show="activeFilter === 'semua' || activeFilter === 'sejarah'" x-transition.opacity.duration.500ms class="py-16 md:py-24 bg-background">
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">
            
            <div class="flex items-center gap-4 mb-12">
                <div class="w-12 h-12 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[24px]">account_balance</span>
                </div>
                <div>
                    <h2 class="font-display-md text-3xl font-bold text-on-background">Situs Punden & <span class="text-secondary">Petilasan</span></h2>
                    <p class="font-body-sm text-on-surface-variant mt-1">Jelajahi nilai historis tinggi dari jejak para nenek moyang pembabat alas desa.</p>
                </div>
            </div>

            <!-- Grid Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                @foreach($sites as $site)
                <!-- Card -->
                <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm border border-outline-variant/30 group hover:shadow-xl transition-all duration-300 transform hover:-translate-y-2 flex flex-col relative">
                    <!-- Smart QR Guide Label -->
                    <div class="absolute top-4 right-4 z-20 bg-inverse-surface/90 backdrop-blur-sm text-inverse-on-surface font-label-sm px-3 py-1.5 rounded-full shadow-lg flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">qr_code_scanner</span>
                        Smart QR Guide
                    </div>
                    
                    <div class="relative h-64 overflow-hidden">
                        <div class="absolute inset-0 bg-primary/20 group-hover:bg-transparent transition-colors duration-500 z-10 mix-blend-multiply"></div>
                        <img src="{{ empty($site->image_path) ? asset('images/dummy/wisata1.jpg') : (Str::startsWith($site->image_path, 'images/dummy/') ? asset($site->image_path) : asset('storage/' . $site->image_path)) }}" alt="{{ $site->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 sepia-[0.3]">
                    </div>
                    
                    <div class="p-6 md:p-8 flex-grow flex flex-col bg-surface-container-lowest relative z-20 -mt-6 mx-4 rounded-2xl border border-outline-variant/20 shadow-md">
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-2">{{ $site->name }}</h3>
                        <div class="text-secondary font-label-sm mb-4 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[16px]">location_on</span> Koordinat: {{ $site->latitude ?? '-' }}, {{ $site->longitude ?? '-' }}
                        </div>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3 mb-4">{!! strip_tags($site->description) !!}</p>
                        <a href="{{ route('wisata.show', $site->slug) }}" class="w-full mt-auto bg-primary/5 hover:bg-primary text-primary hover:text-on-primary font-label-md py-3 rounded-xl transition-colors border border-primary/20 hover:border-primary flex items-center justify-center gap-2">
                            Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- 3. Tradisi & Seni Budaya (Kearifan Lokal) - Zig-Zag Layout -->
    <section x-show="activeFilter === 'semua' || activeFilter === 'budaya'" x-transition.opacity.duration.500ms class="py-16 md:py-24 bg-surface-container-low overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">
            
            <div class="text-center max-w-[48rem] mx-auto mb-16">
                <h2 class="font-display-md text-3xl md:text-4xl font-bold text-on-background mb-4">Tradisi & <span class="text-tertiary">Seni Budaya</span></h2>
                <p class="font-body-md text-on-surface-variant text-lg">
                    Kehidupan masyarakat yang harmonis dibalut dengan pelestarian tradisi asli Javanese yang telah diwariskan turun-temurun.
                </p>
            </div>

            <div class="space-y-16 md:space-y-24">
                
                <!-- Zig-zag Item 1 -->
                <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
                    <div class="w-full md:w-1/2">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                            <div class="absolute inset-0 bg-tertiary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                            <img src="{{ asset('images/dummy/tradisi1.jpg') }}" alt="Grebeg Suro" class="w-full h-[300px] md:h-[400px] object-cover transform transition-transform duration-700 group-hover:scale-105">
                            
                            <div class="absolute bottom-6 left-6 z-20 bg-surface-container-lowest p-4 rounded-2xl shadow-lg border border-outline-variant/30 flex items-center gap-4">
                                <div class="w-12 h-12 bg-tertiary/10 text-tertiary rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined">celebration</span>
                                </div>
                                <div>
                                    <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Ritual Tahunan</div>
                                    <div class="font-headline-md font-bold text-on-surface">Bulan Suro</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-4">
                        <h3 class="font-display-md text-3xl font-bold text-on-background text-tertiary">Ritual Adat & Seni Keagamaan</h3>
                        <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                            Ritual tahunan setiap bulan Suro yang menjadi puncak rasa syukur masyarakat desa, selamatan desa, hingga adat keagamaan seperti Albanjari dan Terbang Jidor. Tradisi ini melibatkan seluruh elemen warga untuk memanjatkan doa bersama.
                        </p>
                    </div>
                </div>

                <!-- Zig-zag Item 2 (Reversed) -->
                <div class="flex flex-col md:flex-row-reverse items-center gap-8 md:gap-16">
                    <div class="w-full md:w-1/2">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                            <div class="absolute inset-0 bg-secondary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                            <img src="{{ asset('images/dummy/tradisi2.jpg') }}" alt="Tradisi Daur Hidup" class="w-full h-[300px] md:h-[400px] object-cover transform transition-transform duration-700 group-hover:scale-105 filter sepia-[0.2]">
                            
                            <div class="absolute bottom-6 right-6 z-20 bg-surface-container-lowest p-4 rounded-2xl shadow-lg border border-outline-variant/30 flex items-center gap-4">
                                <div class="text-right">
                                    <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Keagamaan</div>
                                    <div class="font-headline-md font-bold text-on-surface">Akulturasi</div>
                                </div>
                                <div class="w-12 h-12 bg-secondary/10 text-secondary rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined">mosque</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-4">
                        <h3 class="font-display-md text-3xl font-bold text-on-background text-secondary">Tradisi Daur Hidup & Keagamaan</h3>
                        <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                            Sebuah bukti indah dari akulturasi budaya Islam dan Jawa yang sangat kental. Masyarakat Tulusbesar senantiasa menjaga keutuhan religiusitas melalui rangkaian tradisi Nyadran (ziarah leluhur), Mithoni (syukuran tujuh bulanan), dan Tahlilan rutin di pelosok RT.
                        </p>
                    </div>
                </div>

                <!-- Zig-zag Item 3 -->
                <div class="flex flex-col md:flex-row items-center gap-8 md:gap-16">
                    <div class="w-full md:w-1/2">
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl group">
                            <div class="absolute inset-0 bg-primary/10 group-hover:bg-transparent transition-colors duration-500 z-10"></div>
                            <img src="{{ asset('images/dummy/tradisi3.jpg') }}" alt="Bantengan" class="w-full h-[300px] md:h-[400px] object-cover transform transition-transform duration-700 group-hover:scale-105 filter contrast-125">
                            
                            <div class="absolute bottom-6 left-6 z-20 bg-surface-container-lowest p-4 rounded-2xl shadow-lg border border-outline-variant/30 flex items-center gap-4">
                                <div class="w-12 h-12 bg-primary/10 text-primary rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined">theater_comedy</span>
                                </div>
                                <div>
                                    <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Identitas Sosial</div>
                                    <div class="font-headline-md font-bold text-on-surface">Seni Rakyat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 space-y-4">
                        <h3 class="font-display-md text-3xl font-bold text-on-background text-primary">Kesenian Tradisional & Modern</h3>
                        <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                            Desa Tulusbesar adalah desa binaan Wisata Seni Budaya. Terdapat beragam kesenian seperti Wayang Kulit, Karawitan, Kuda Lumping (Jaranan), Wayang Topeng Malangan, hingga kesenian modern. Pertunjukan sering digelar di Panggung Terbuka (Open Stage) dan Padepokan Seni Mangun Dharmo.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- 5. CTA (Call-to-Action) ke WebGIS -->
    <section class="py-16 md:py-20 bg-primary relative overflow-hidden">
        <!-- Abstract Decoration -->
        <div class="absolute right-0 top-0 w-2/3 h-full bg-gradient-to-l from-secondary/40 to-transparent pointer-events-none"></div>
        <div class="absolute inset-0 opacity-10 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'20\' height=\'20\' viewBox=\'0 0 20 20\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\' fill-rule=\'evenodd\'%3E%3Ccircle cx=\'3\' cy=\'3\' r=\'3\'/%3E%3Ccircle cx=\'13\' cy=\'13\' r=\'3\'/%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <span class="material-symbols-outlined absolute -left-10 -bottom-10 text-[250px] text-white/5 pointer-events-none">map</span>

        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10">
            <div class="bg-surface-container-lowest/10 backdrop-blur-md border border-white/20 rounded-3xl p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8 md:gap-12 shadow-2xl">
                <div class="md:w-2/3 text-on-primary text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-3 mb-4">
                        <span class="material-symbols-outlined bg-white/20 p-2 rounded-xl">pin_drop</span>
                        <span class="font-label-md font-bold tracking-widest uppercase text-white/80">Sistem Informasi Geografis</span>
                    </div>
                    <h2 class="font-display-md text-3xl md:text-4xl font-bold mb-4 leading-tight">
                        Ingin melihat langsung rute ke Situs Punden, Sentra Industri Tahu, atau Fasilitas Umum kami?
                    </h2>
                    <p class="font-body-md text-lg text-white/90">
                        Akses peta pintar (WebGIS) kami untuk menemukan berbagai titik lokasi di Desa Tulusbesar dengan mudah.
                    </p>
                </div>
                <div class="md:w-1/3 flex justify-center md:justify-end shrink-0 w-full md:w-auto">
                    <a href="{{ route('peta') }}" class="w-full md:w-auto bg-tertiary-fixed hover:bg-white text-on-tertiary-fixed font-label-md px-8 py-5 rounded-xl shadow-xl transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 text-lg font-bold group">
                        <span class="material-symbols-outlined group-hover:scale-110 transition-transform">explore</span>
                        Buka Peta WebGIS Desa
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
</div>
@endsection
