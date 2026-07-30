@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="mb-4">
        <a href="{{ route('tutorials.index') }}" class="text-primary hover:underline flex items-center gap-2">
            <span class="material-symbols-outlined">arrow_back</span> Kembali ke daftar
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        @if($tutorial->video_url)
            <div class="aspect-w-16 aspect-h-9 w-full bg-black">
                <iframe src="{{ str_replace('watch?v=', 'embed/', $tutorial->video_url) }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-[500px]"></iframe>
            </div>
        @elseif($tutorial->thumbnail_path)
            <img src="{{ Storage::url($tutorial->thumbnail_path) }}" alt="{{ $tutorial->title }}" class="w-full h-auto object-cover max-h-[500px]">
        @endif

        <div class="p-8">
            <h1 class="text-3xl font-bold mb-4">{{ $tutorial->title }}</h1>
            
            <div class="flex flex-col md:flex-row gap-8">
                <div class="flex-grow">
                    <div class="prose max-w-none">
                        <p class="text-lg text-gray-700 mb-6 font-medium">{{ $tutorial->description }}</p>
                        
                        <div class="text-gray-800">
                            {!! nl2br(e($tutorial->content)) !!}
                        </div>
                    </div>
                </div>
                
                <div class="md:w-64 flex-shrink-0">
                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-center">
                        <h4 class="font-bold mb-2">QR Code Akses Cepat</h4>
                        <p class="text-sm text-gray-600 mb-4">Scan QR code ini untuk membagikan tutorial.</p>
                        
                        <div class="bg-white p-2 rounded-lg inline-block shadow-sm">
                            <img src="{{ $qrcode }}" alt="QR Code" class="w-48 h-48 mx-auto" />
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ $qrcode }}" download="QR-{{ $tutorial->slug }}.svg" class="text-sm text-primary hover:underline flex items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[16px]">download</span> Unduh QR Code
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
