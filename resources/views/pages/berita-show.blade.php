@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar bg-surface-container-lowest">
    <!-- Hero Header -->
    <section class="relative pt-6 pb-4 md:pt-8 md:pb-6 bg-surface-container-low overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin relative z-10">
            <a href="{{ route('publikasi') }}" class="inline-flex items-center gap-2 text-primary font-label-md hover:text-secondary-container transition-colors mb-4">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Publikasi
            </a>
            
            <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-3">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d F Y') }}</time>
                <span class="mx-2">•</span>
                <span class="material-symbols-outlined text-[16px]">person</span> 
                <span>Admin Desa</span>
            </div>
            
            <h1 class="font-display-lg text-3xl md:text-5xl font-bold text-on-background leading-tight">
                {{ $berita->title }}
            </h1>
        </div>
    </section>

    <!-- Main Content -->
    <section class="pt-6 pb-24 md:pt-8">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin">
            <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
                <!-- Main Article -->
                <div class="lg:w-2/3">
                    <!-- Featured Image -->
                    @php
                        $images = is_array($berita->images) && count($berita->images) > 0 ? $berita->images : [$berita->image_path];
                        $hasMultiple = count($images) > 1;
                    @endphp
                    <div class="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-md mb-8 relative group"
                         @if($hasMultiple)
                         x-data="{ activeSlide: 0, slides: {{ count($images) }} }"
                         x-init="setInterval(() => { activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1 }, 3500)"
                         @endif
                    >
                        @if($hasMultiple)
                            @foreach($images as $index => $img)
                            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                                 x-show="activeSlide === {{ $index }}"
                                 x-transition:enter="transition-opacity duration-1000"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition-opacity duration-1000"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0">
                                <img src="{{ Str::startsWith($img, 'images/dummy/') ? asset($img) : url('/download-file?path=' . $img) }}" alt="{{ $berita->title }} - Slide {{ $index + 1 }}" class="w-full h-full object-cover">
                            </div>
                            @endforeach
                            
                            <!-- Indicators -->
                            <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                                @foreach($images as $index => $img)
                                <button class="w-2.5 h-2.5 rounded-full transition-colors duration-300 shadow-sm border border-black/10"
                                        :class="activeSlide === {{ $index }} ? 'bg-white' : 'bg-white/40 hover:bg-white/80'"
                                        @click="activeSlide = {{ $index }}"></button>
                                @endforeach
                            </div>

                            <!-- Navigation Buttons -->
                            <button @click="activeSlide = activeSlide === 0 ? slides - 1 : activeSlide - 1"
                                    class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10 backdrop-blur-sm">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button @click="activeSlide = activeSlide === slides - 1 ? 0 : activeSlide + 1"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-black/30 hover:bg-black/50 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 z-10 backdrop-blur-sm">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        @else
                            <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : url('/download-file?path=' . $berita->image_path)) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    @if($berita->video_link)
                        @php
                            $ytId = null;
                            preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $berita->video_link, $match);
                            $ytId = $match[1] ?? null;
                        @endphp
                        @if($ytId)
                            <div class="w-full aspect-video rounded-3xl overflow-hidden shadow-md mb-12">
                                <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $ytId }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @endif
                    @endif

                    <!-- Article Body -->
                    <article class="prose prose-lg prose-headings:font-display-md prose-headings:font-bold prose-headings:text-on-background prose-p:font-body-md prose-p:text-on-surface-variant prose-a:text-primary hover:prose-a:text-secondary max-w-none text-justify
                        prose-img:rounded-2xl prose-img:shadow-sm prose-img:max-w-full prose-img:h-auto
                        prose-figure:max-w-full prose-figure:m-0 prose-figcaption:text-center prose-figcaption:text-sm prose-figcaption:text-on-surface-variant
                        prose-video:w-full prose-video:rounded-2xl
                        [&>figure>img]:w-full [&>figure>img]:object-contain">
                        {!! $berita->content !!}
                    </article>

                    <!-- Share & Tags (Optional) -->
                    <div class="mt-16 pt-8 border-t border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="font-label-md text-on-surface-variant">
                            Bagikan artikel ini:
                        </div>
                        <div class="flex gap-2">
                            <!-- WhatsApp Share -->
                            <a href="https://api.whatsapp.com/send?text={{ urlencode('Baca ' . $berita->title . ' di Web Desa Tulusbesar: ' . url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#25D366]/10 border border-[#25D366]/50 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-colors" title="Bagikan ke WhatsApp">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.304-.058.116-.087.188-.173.289l-.26.304c-.087.086-.177.18-.076.354.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86s.274.072.376-.043c.101-.116.433-.506.549-.68.116-.173.231-.145.39-.087s1.011.477 1.184.564.289.13.332.202c.045.072.045.419-.1.824zm-3.423-14.416c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm.029 18.88c-1.161 0-2.305-.292-3.318-.844l-3.677.964.984-3.595c-.607-1.052-.927-2.246-.926-3.468.001-3.825 3.113-6.937 6.937-6.937 1.856.001 3.598.723 4.907 2.034 1.31 1.311 2.031 3.054 2.03 4.908-.001 3.825-3.113 6.938-6.937 6.938z"/></svg>
                            </a>
                            <!-- Facebook Share -->
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="w-10 h-10 rounded-full bg-[#1877F2]/10 border border-[#1877F2]/50 flex items-center justify-center text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition-colors" title="Bagikan ke Facebook">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                            </a>
                            <!-- Copy Link -->
                            <button onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('Tautan disalin!');" class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-primary hover:text-on-primary hover:border-primary transition-colors" title="Salin Tautan">
                                <span class="material-symbols-outlined">link</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar / Recommendations -->
                <aside class="lg:w-1/3">
                    <div class="sticky top-24">
                        <h3 class="font-display-md text-2xl font-bold text-on-background mb-6">Berita Lainnya</h3>
                        
                        <div class="space-y-6">
                            @if(isset($recommendations) && $recommendations->count() > 0)
                                @foreach($recommendations as $rec)
                                <a href="{{ route('berita.show', $rec->slug) }}" class="group flex gap-4 items-start">
                                    <div class="w-24 h-24 shrink-0 rounded-xl overflow-hidden bg-surface-variant">
                                        <img src="{{ empty($rec->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($rec->image_path, 'images/dummy/') ? asset($rec->image_path) : url('/download-file?path=' . $rec->image_path)) }}" alt="{{ $rec->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-headline-sm text-lg font-bold text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">{{ $rec->title }}</h4>
                                        <div class="font-label-sm text-on-surface-variant flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                            <time>{{ \Carbon\Carbon::parse($rec->published_at ?? $rec->created_at)->translatedFormat('d M Y') }}</time>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <p class="text-on-surface-variant font-body-sm">Belum ada berita lainnya.</p>
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
