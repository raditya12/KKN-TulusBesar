@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8 text-center text-primary">Inovasi & Tutorial Desa Tulusbesar</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tutorials as $tutorial)
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition">
                @if($tutorial->thumbnail_path)
                    <img src="{{ Storage::url($tutorial->thumbnail_path) }}" alt="{{ $tutorial->title }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-500 material-symbols-outlined text-4xl">video_library</span>
                    </div>
                @endif
                <div class="p-6">
                    <h3 class="font-bold text-xl mb-2">{{ $tutorial->title }}</h3>
                    <p class="text-gray-600 mb-4 line-clamp-2">{{ $tutorial->description }}</p>
                    <a href="{{ route('tutorials.show', $tutorial->slug) }}" class="inline-block bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Lihat Tutorial</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                <span class="material-symbols-outlined text-6xl mb-4 block">sentiment_dissatisfied</span>
                <p>Belum ada inovasi/tutorial yang dipublikasikan.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
