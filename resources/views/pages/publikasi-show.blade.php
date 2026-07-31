@extends('layouts.app')

@section('content')
@php
    $ytId = null;
    if($publikasi->youtube_url) {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $publikasi->youtube_url, $match);
        $ytId = $match[1] ?? null;
    }
@endphp
<div class="w-full overflow-y-auto custom-scrollbar bg-surface-container-lowest">
    <!-- Hero Header -->
    <section class="relative pt-6 pb-4 md:pt-8 md:pb-6 bg-surface-container-low overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin relative z-10">
            <a href="{{ route('publikasi') }}" class="inline-flex items-center gap-2 text-primary font-label-md hover:text-secondary-container transition-colors mb-4">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Publikasi
            </a>
            
            <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-3">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                <time>{{ $publikasi->created_at->translatedFormat('d F Y') }}</time>
                <span class="mx-2">•</span>
                <span class="inline-flex px-2 py-0.5 rounded-full bg-primary/10 text-primary border border-primary/20 text-[10px] font-bold tracking-wider uppercase">
                    {{ $publikasi->category }}
                </span>
            </div>
            
            <h1 class="font-display-lg text-3xl md:text-5xl font-bold text-on-background leading-tight">
                {{ $publikasi->title }}
            </h1>
        </div>
    </section>

    <!-- Main Content -->
    <section class="pt-6 pb-24 md:pt-8">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
                <!-- Main Article -->
                <div class="lg:w-2/3">
                    
                    <!-- Media Section (Photo Gallery Slider) -->
                    @if(!empty($publikasi->images) && is_array($publikasi->images) && count($publikasi->images) > 0)
                    <div class="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-md mb-8 relative group bg-black"
                         x-data="{ currentSlide: 0, slides: {{ json_encode(array_map(function($img) { return asset('storage/' . $img); }, $publikasi->images)) }} }"
                         x-init="setInterval(() => { currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1 }, 4000)">
                        
                        <div class="relative w-full h-full flex items-center justify-center">
                            <template x-for="(slide, index) in slides" :key="index">
                                <img :src="slide" class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500"
                                     :class="currentSlide === index ? 'opacity-100 z-10' : 'opacity-0 z-0'" alt="{{ $publikasi->title }}">
                            </template>
                            
                            <!-- Controls -->
                            <button x-show="slides.length > 1" @click="currentSlide = (currentSlide === 0) ? slides.length - 1 : currentSlide - 1" class="absolute left-4 z-20 w-10 h-10 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white hover:bg-primary transition-colors border border-white/20 shadow-lg">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button x-show="slides.length > 1" @click="currentSlide = (currentSlide === slides.length - 1) ? 0 : currentSlide + 1" class="absolute right-4 z-20 w-10 h-10 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white hover:bg-primary transition-colors border border-white/20 shadow-lg">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                            
                            <!-- Indicators -->
                            <div x-show="slides.length > 1" class="absolute bottom-4 left-0 right-0 z-20 flex justify-center gap-2">
                                <template x-for="(slide, index) in slides" :key="index">
                                    <button @click="currentSlide = index" class="h-2 rounded-full transition-all duration-300"
                                            :class="currentSlide === index ? 'w-8 bg-primary' : 'w-2 bg-white/50 hover:bg-white/80'"></button>
                                </template>
                            </div>
                        </div>
                    </div>
                    @elseif($publikasi->cover_image)
                    <div class="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-md mb-8 bg-surface-container">
                        <img src="{{ asset('storage/' . $publikasi->cover_image) }}" alt="{{ $publikasi->title }}" class="w-full h-full object-cover">
                    </div>
                    @endif

                    <!-- Media Section (Video) -->
                    @if($ytId)
                    <div class="w-full rounded-3xl overflow-hidden shadow-md mb-8 bg-black">
                        <div class="relative w-full flex items-center justify-center bg-black" style="aspect-ratio: 16/9;">
                            <iframe id="youtubeIframe" class="absolute inset-0 w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}?rel=0" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif

                    <!-- Article Body -->
                    <article class="prose prose-lg prose-headings:font-display-md prose-headings:font-bold prose-headings:text-on-background prose-p:font-body-md prose-p:text-on-surface-variant prose-a:text-primary hover:prose-a:text-secondary max-w-none text-justify
                        prose-img:rounded-2xl prose-img:shadow-sm prose-img:max-w-full prose-img:h-auto
                        prose-figure:max-w-full prose-figure:m-0 prose-figcaption:text-center prose-figcaption:text-sm prose-figcaption:text-on-surface-variant
                        prose-video:w-full prose-video:rounded-2xl
                        [&>figure>img]:w-full [&>figure>img]:object-contain">
                        @if(strip_tags($publikasi->description))
                            {!! $publikasi->description !!}
                        @else
                            <p><em>Tidak ada deskripsi tambahan untuk publikasi ini.</em></p>
                        @endif
                    </article>

                    <!-- Share Section -->
                    <div class="mt-16 pt-8 border-t border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="font-label-md text-on-surface-variant">
                            Bagikan publikasi ini:
                        </div>
                        <div class="flex gap-2">
                            <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-primary hover:text-on-primary hover:border-primary transition-colors"><span class="material-symbols-outlined">share</span></button>
                            <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-primary hover:text-on-primary hover:border-primary transition-colors"><span class="material-symbols-outlined">link</span></button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Recommendations -->
                <aside class="lg:w-1/3">
                    <div class="sticky top-24">
                        <h3 class="font-display-md text-2xl font-bold text-on-background mb-6">Publikasi Lainnya</h3>
                        
                        <div class="space-y-6">
                            @php
                                $recommendations = \App\Models\Publication::where('id', '!=', $publikasi->id)->where('is_active', true)->latest()->take(3)->get();
                            @endphp
                            
                            @if(isset($recommendations) && $recommendations->count() > 0)
                                @foreach($recommendations as $rec)
                                @php
                                    $recYtId = null;
                                    if($rec->youtube_url) {
                                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $rec->youtube_url, $match);
                                        $recYtId = $match[1] ?? null;
                                    }
                                @endphp
                                <a href="{{ route('publikasi.inovasi.show', $rec->id) }}" class="group flex gap-4 items-start">
                                    <div class="w-24 h-24 shrink-0 rounded-xl overflow-hidden bg-surface-variant relative">
                                        @if($rec->cover_image)
                                            <img src="{{ asset('storage/' . $rec->cover_image) }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @elseif($recYtId)
                                            <img src="https://img.youtube.com/vi/{{ $recYtId }}/default.jpg" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-on-surface-variant">
                                                <span class="material-symbols-outlined text-[24px]">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-headline-sm text-lg font-bold text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">{{ $rec->title }}</h4>
                                        <div class="font-label-sm text-on-surface-variant flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                            <time>{{ $rec->created_at->translatedFormat('d M Y') }}</time>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <p class="text-on-surface-variant font-body-sm">Belum ada publikasi lainnya.</p>
                            @endif
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <x-footer />
</div>
@endsection
