@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar bg-surface-container-lowest">
    <!-- Hero Header -->
    <section class="relative pt-24 md:pt-32 pb-12 bg-surface-container-low overflow-hidden">
        <div class="max-w-screen-md mx-auto px-4 relative z-10">
            <a href="{{ route('publikasi') }}" class="inline-flex items-center gap-2 text-primary font-label-md hover:text-secondary-container transition-colors mb-6">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span> Kembali ke Publikasi
            </a>
            
            <div class="flex items-center gap-2 text-on-surface-variant font-label-sm mb-4">
                <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d F Y') }}</time>
                <span class="mx-2">•</span>
                <span class="material-symbols-outlined text-[16px]">person</span> 
                <span>Admin Desa</span>
            </div>
            
            <h1 class="font-display-lg text-3xl md:text-5xl font-bold text-on-background mb-8 leading-tight">
                {{ $berita->title }}
            </h1>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-8 pb-24">
        <div class="max-w-screen-md mx-auto px-4">
            <!-- Featured Image -->
            <div class="w-full h-[300px] md:h-[500px] rounded-3xl overflow-hidden shadow-md mb-12">
                <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : asset('storage/' . $berita->image_path)) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover">
            </div>

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
                    <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-primary hover:text-on-primary hover:border-primary transition-colors"><span class="material-symbols-outlined">share</span></button>
                    <button class="w-10 h-10 rounded-full bg-surface-container border border-outline-variant/50 flex items-center justify-center text-on-surface hover:bg-primary hover:text-on-primary hover:border-primary transition-colors"><span class="material-symbols-outlined">link</span></button>
                </div>
            </div>
        </div>
    </section>

    <x-footer />
</div>
@endsection
