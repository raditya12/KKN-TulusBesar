@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar bg-surface-container-lowest">
    <!-- Hero Header -->
    <section class="relative pt-6 pb-4 md:pt-8 md:pb-6 bg-surface-container-low overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin relative z-10">
            <a href="{{ route('umkm') }}" class="inline-flex items-center gap-2 text-primary font-label-md hover:text-secondary-container transition-colors mb-4">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Katalog UMKM
            </a>
            
            <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-3">
                <span class="inline-block px-3 py-1 bg-secondary/10 text-secondary rounded-full">{{ $umkm->category }}</span>
            </div>
            
            <h1 class="font-display-lg text-3xl md:text-5xl font-bold text-on-background leading-tight">
                {{ $umkm->name }}
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
                    <div class="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-md mb-12">
                        <img src="{{ empty($umkm->image_path) ? asset('images/dummy/umkm1.jpg') : (Str::startsWith($umkm->image_path, 'images/dummy/') ? asset($umkm->image_path) : asset('storage/' . $umkm->image_path)) }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
                    </div>

                    <!-- Article Body -->
                    <article class="prose prose-lg prose-headings:font-display-md prose-headings:font-bold prose-headings:text-on-background prose-p:font-body-md prose-p:text-on-surface-variant prose-a:text-primary hover:prose-a:text-secondary max-w-none text-justify
                        prose-img:rounded-2xl prose-img:shadow-sm prose-img:max-w-full prose-img:h-auto
                        prose-figure:max-w-full prose-figure:m-0 prose-figcaption:text-center prose-figcaption:text-sm prose-figcaption:text-on-surface-variant
                        prose-video:w-full prose-video:rounded-2xl
                        [&>figure>img]:w-full [&>figure>img]:object-contain">
                        {!! $umkm->description !!}
                    </article>

                    <!-- Share -->
                    <div class="mt-16 pt-8 border-t border-outline-variant/30 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="font-label-md text-on-surface-variant">
                            Bagikan produk ini:
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
                        <h3 class="font-display-md text-2xl font-bold text-on-background mb-6">UMKM Lainnya</h3>
                        
                        <div class="space-y-6">
                            @if(isset($recommendations) && $recommendations->count() > 0)
                                @foreach($recommendations as $rec)
                                <a href="{{ route('umkm.show', $rec->slug) }}" class="group flex gap-4 items-start">
                                    <div class="w-24 h-24 shrink-0 rounded-xl overflow-hidden bg-surface-variant">
                                        <img src="{{ empty($rec->image_path) ? asset('images/dummy/umkm1.jpg') : (Str::startsWith($rec->image_path, 'images/dummy/') ? asset($rec->image_path) : asset('storage/' . $rec->image_path)) }}" alt="{{ $rec->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-headline-sm text-lg font-bold text-on-surface group-hover:text-primary transition-colors line-clamp-2 mb-1">{{ $rec->name }}</h4>
                                        <div class="font-label-sm text-on-surface-variant flex items-center gap-1">
                                            <span class="inline-block px-2 py-0.5 bg-secondary/10 text-secondary rounded-full text-xs">{{ $rec->category }}</span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            @else
                                <p class="text-on-surface-variant font-body-sm">Belum ada UMKM lainnya.</p>
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
