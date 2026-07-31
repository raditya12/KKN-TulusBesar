@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar">

    @php
        $slideImages = $news
            ->filter(fn($n) => !empty($n->image_path))
            ->map(fn($n) => Str::startsWith($n->image_path, 'images/dummy/')
                ? asset($n->image_path)
                : asset('storage/' . $n->image_path)
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
                @foreach($news as $berita)
                <!-- News Card -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm border border-outline-variant/30 group hover:shadow-lg transition-all flex flex-col">
                    <div class="h-48 overflow-hidden relative">
                        <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : asset('storage/' . $berita->image_path)) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
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
                @endforeach
            </div>
            
            <div class="mt-8 text-center md:hidden">
                <button class="font-label-md text-primary border border-primary px-6 py-2 rounded-full w-full">Lihat Berita Lainnya</button>
            </div>
        </div>
    </section>

    <!-- Galeri Inovasi Digital -->
    <section class="py-16 md:py-24 bg-surface-container-low border-b border-outline-variant/30 relative overflow-hidden">
        <!-- Decorative Background Element -->
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-primary/5 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-[400px] h-[400px] bg-secondary/5 rounded-full blur-[80px] pointer-events-none"></div>

        <div class="max-w-screen-xl mx-auto px-4 md:px-container-margin relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div class="max-w-2xl">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-tertiary/10 text-tertiary font-label-sm mb-4 border border-tertiary/20">
                        <span class="material-symbols-outlined text-[16px]">play_circle</span>
                        Galeri Video
                    </div>
                    <h2 class="font-display-md text-3xl md:text-4xl font-bold text-on-background">Inovasi <span class="text-tertiary">Digital & Publikasi</span></h2>
                    <p class="font-body-md text-on-surface-variant mt-4 text-lg leading-relaxed">Kumpulan video dokumentasi, tutorial digital, dan publikasi visual kegiatan Desa Tulusbesar.</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($publications as $pub)
                @php
                    $ytId = null;
                    if($pub->youtube_url) {
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $pub->youtube_url, $match);
                        $ytId = $match[1] ?? null;
                    }
                @endphp
                <!-- Video Card Modern UI -->
                <a href="{{ route('publikasi.inovasi.show', $pub->id) }}" class="relative bg-surface-container-lowest rounded-[2rem] overflow-hidden shadow-sm border border-outline-variant/40 group hover:shadow-[0_20px_40px_-15px_rgba(0,0,0,0.1)] hover:-translate-y-2 transition-all duration-500 flex flex-col cursor-pointer h-full block">
                    
                    <!-- Image & Overlay Container -->
                    <div class="h-60 overflow-hidden relative bg-surface-container">
                        @if($pub->cover_image)
                            <img src="{{ asset('storage/' . $pub->cover_image) }}" alt="{{ $pub->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        @elseif($ytId)
                            <!-- Try maxresdefault, fallback to hqdefault -->
                            <img src="https://img.youtube.com/vi/{{ $ytId }}/maxresdefault.jpg" 
                                 onerror="this.onerror=null; this.src='https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg';" 
                                 alt="{{ $pub->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-on-surface-variant bg-surface-variant/30">
                                <span class="material-symbols-outlined text-4xl mb-2 opacity-50">image</span>
                                <span class="font-label-md">Tidak ada foto</span>
                            </div>
                        @endif
                    </div>

                    <!-- Content Area -->
                    <div class="p-6 md:p-8 flex-grow flex flex-col bg-surface-container-lowest relative z-10">
                        <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-3">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                            <time>{{ $pub->created_at->translatedFormat('d F Y') }}</time>
                        </div>
                        
                        <h3 class="font-display-sm text-xl md:text-2xl font-bold text-on-surface mb-3 group-hover:text-primary transition-colors leading-tight line-clamp-2">
                            {{ $pub->title }}
                        </h3>
                        
                        <div class="mb-4">
                            <span class="inline-flex px-3 py-1 bg-surface-variant/50 text-on-surface-variant rounded-full text-[11px] font-bold tracking-wider uppercase border border-outline-variant/50">
                                {{ $pub->category }}
                            </span>
                        </div>
                        
                        <!-- Call to Action -->
                        <div class="mt-auto pt-5 border-t border-outline-variant/30">
                            <span class="inline-flex items-center gap-2 text-primary font-label-md group-hover:translate-x-2 transition-transform duration-300">
                                Klik Selengkapnya <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
                
                @if($publications->isEmpty())
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center border-2 border-dashed border-outline-variant/50 rounded-3xl bg-surface-container-lowest/50">
                    <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">video_library</span>
                    <h3 class="font-headline-md text-on-surface mb-2 font-bold">Belum Ada Publikasi Video</h3>
                    <p class="font-body-md text-on-surface-variant max-w-md">Video inovasi dan publikasi yang ditambahkan melalui panel admin akan muncul di sini.</p>
                </div>
                @endif
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

            <div class="bg-white rounded-3xl border border-outline-variant/40 shadow-sm overflow-hidden">
                <!-- Search & Filter Bar -->
                <div class="p-4 md:p-6 bg-surface-container-low border-b border-outline-variant/40 flex flex-col md:flex-row gap-4 justify-between items-center">
                    <div class="relative w-full md:w-96">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" placeholder="Cari dokumen..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-sm bg-surface-container-lowest">
                    </div>
                    <select class="w-full md:w-auto px-4 py-3 rounded-xl border border-outline-variant/50 font-body-sm outline-none bg-surface-container-lowest text-on-surface">
                        <option>Semua Kategori</option>
                        <option>Laporan Keuangan</option>
                        <option>Formulir Pelayanan</option>
                        <option>Regulasi Desa</option>
                    </select>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-variant/30 text-on-surface-variant font-label-sm border-b border-outline-variant/30 uppercase tracking-wider">
                                <th class="px-6 py-4">Nama Dokumen</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4">Tanggal Diperbarui</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/20">
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined">picture_as_pdf</span>
                                        </div>
                                        <div>
                                            <div class="font-label-md font-bold text-on-surface">Laporan Realisasi APBDes 2025</div>
                                            <div class="font-body-sm text-on-surface-variant text-xs">2.4 MB</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">Laporan Keuangan</td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">15 Jan 2026</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:text-secondary-container transition-colors flex items-center gap-1 ml-auto font-label-sm">
                                        <span class="material-symbols-outlined text-[18px]">download</span> Unduh
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined">description</span>
                                        </div>
                                        <div>
                                            <div class="font-label-md font-bold text-on-surface">Formulir Pengantar RT/RW</div>
                                            <div class="font-body-sm text-on-surface-variant text-xs">156 KB • DOCX</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">Formulir Pelayanan</td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">02 Feb 2026</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:text-secondary-container transition-colors flex items-center gap-1 ml-auto font-label-sm">
                                        <span class="material-symbols-outlined text-[18px]">download</span> Unduh
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-surface-container/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                            <span class="material-symbols-outlined">picture_as_pdf</span>
                                        </div>
                                        <div>
                                            <div class="font-label-md font-bold text-on-surface">Perdes No 4 Tahun 2025 ttg Pengelolaan Sampah</div>
                                            <div class="font-body-sm text-on-surface-variant text-xs">1.8 MB</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">Regulasi Desa</td>
                                <td class="px-6 py-4 font-body-sm text-on-surface-variant">10 Des 2025</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="text-primary hover:text-secondary-container transition-colors flex items-center gap-1 ml-auto font-label-sm">
                                        <span class="material-symbols-outlined text-[18px]">download</span> Unduh
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
</div>
@endsection
