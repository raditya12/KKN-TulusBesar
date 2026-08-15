@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar">

    @php
        $slideImages = $news
            ->filter(fn($n) => !empty($n->image_path))
            ->map(fn($n) => Str::startsWith($n->image_path, 'images/dummy/')
                ? asset($n->image_path)
                : \Illuminate\Support\Facades\Storage::disk('public')->url($n->image_path)
            )
            ->values()
            ->toArray();
        if (empty($slideImages)) {
            $slideImages = [
                asset('images/dummy/hero.jpg'),
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
                        alt="Foto Berita Desa"
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
                    :class="current === index ? 'w-6 h-2.5 bg-secondary' : 'w-2.5 h-2.5 bg-surface-container/60 hover:bg-secondary/60'"
                ></button>
            </template>
        </div>

        <!-- Pattern overlay -->
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none z-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23fd934c\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-20 text-center">
            <span class="font-label-md text-secondary tracking-widest uppercase mb-4 block">Keterbukaan Informasi</span>
            <h1 class="font-display-lg text-4xl md:text-6xl font-bold text-on-background mb-6">Publikasi & <span class="text-primary">Informasi</span></h1>
            <p class="font-body-md text-on-surface-variant text-lg max-w-[42rem] mx-auto leading-relaxed">
                Pusat informasi publik, berita kegiatan kemasyarakatan, serta repositori dokumen resmi Desa Tulusbesar yang dapat diunduh oleh warga.
            </p>
        </div>
    </section>

    <!-- Berita & Artikel -->
    <section class="py-16 md:py-24 bg-background border-b border-outline-variant/30">
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">
            <div class="flex items-end justify-between mb-12">
                <h2 class="font-display-md text-3xl font-bold text-on-background">Berita <span class="text-secondary">Terbaru</span></h2>
                <div class="hidden md:flex items-center gap-2">
                    <button class="w-10 h-10 rounded-full bg-surface-container-low border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-surface-variant transition-colors"><span class="material-symbols-outlined">chevron_left</span></button>
                    <button class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center shadow-md hover:bg-primary/90 transition-colors"><span class="material-symbols-outlined">chevron_right</span></button>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($news as $berita)
                <!-- News Card -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm border border-outline-variant/30 group hover:shadow-lg transition-all flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($berita->image_path)) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-5 flex-grow flex flex-col">
                        <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-2">
                            <span class="material-symbols-outlined text-[14px]">calendar_today</span> 
                            <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d M Y') }}</time>
                        </div>
                        <h3 class="font-headline-md text-lg font-bold text-on-surface mb-2 line-clamp-2 group-hover:text-primary transition-colors flex-grow">{{ $berita->title }}</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-2 mb-4 text-justify">{!! strip_tags($berita->content) !!}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="w-full bg-surface-container hover:bg-primary text-primary hover:text-on-primary font-label-sm py-2 rounded-xl transition-colors border border-outline-variant/50 hover:border-primary flex items-center justify-center gap-2 mt-auto">
                            Selengkapnya <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center bg-surface-container-lowest rounded-3xl border-2 border-outline-variant/30 border-dashed">
                    <span class="material-symbols-outlined text-[48px] text-outline mb-4">newspaper</span>
                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-2">Belum Ada Berita Terbaru</h3>
                    <p class="font-body-md text-on-surface-variant max-w-md mx-auto">Saat ini belum ada publikasi berita atau informasi kegiatan terbaru dari desa. Silakan kunjungi kembali halaman ini nanti.</p>
                </div>
                @endforelse
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <button class="font-label-md text-primary border border-primary px-6 py-2 rounded-full w-full">Lihat Berita Lainnya</button>
            </div>
        </div>
    </section>



    <!-- Repositori Dokumen (Tabel) -->
    <section class="py-16 md:py-24 bg-surface-container-lowest">
        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin">
            <div class="text-center max-w-[48rem] mx-auto mb-12">
                <h2 class="font-display-md text-3xl font-bold text-on-background mb-4">Repositori <span class="text-tertiary">Dokumen</span></h2>
                <p class="font-body-md text-on-surface-variant">Unduh dokumen resmi, formulir pelayanan, laporan keuangan, dan regulasi desa secara transparan.</p>
            </div>

            <livewire:document-repository />
        </div>
    </section>

    <x-footer />
</div>
@endsection
