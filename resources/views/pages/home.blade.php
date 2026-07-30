@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/dummy/hero.jpg') }}');"></div>
            <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center px-container-margin max-w-[56rem] mx-auto flex flex-col items-center gap-lg">
            <span class="px-md py-xs rounded-full bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md tracking-wider uppercase text-sm shadow-xl shadow-primary/20">
                Selamat Datang di
            </span>
            <h1 class="font-display-lg text-[clamp(40px,8vw,80px)] leading-tight text-on-primary font-bold drop-shadow-lg">
                Desa Tulusbesar
            </h1>
            <p class="font-body-lg text-lg md:text-xl text-on-primary/90 max-w-[42rem] drop-shadow-md">
                Harmoni kearifan lokal Javanese dan inovasi tata kelola cerdas dalam satu genggaman. Jelajahi keindahan budaya dan infrastruktur desa kami.
            </p>
            
            <div class="flex flex-wrap items-center justify-center gap-md mt-md">
                <a href="{{ route('peta') }}" class="bg-tertiary-fixed hover:bg-tertiary-fixed-dim text-on-tertiary-fixed font-label-md px-xl py-md rounded-xl transition-all duration-300 shadow-xl shadow-tertiary-fixed/20 flex items-center gap-sm transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">explore</span>
                    Jelajahi WebGIS
                </a>
                <a href="{{ route('profil') }}" class="bg-surface-container-lowest/10 hover:bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md px-xl py-md rounded-xl transition-all duration-300 flex items-center gap-sm transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">info</span>
                    Profil Desa
                </a>
            </div>
        </div>
    </section>

    <!-- Profil Singkat Section -->
    <section class="py-16 md:py-24 bg-background relative overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2xl items-center">
                <div class="space-y-lg relative">
                    <div class="absolute -left-10 -top-10 text-[120px] text-primary/5 font-display-lg font-bold leading-none select-none">SEJARAH</div>
                    <h2 class="font-display-md text-4xl md:text-5xl text-on-background font-bold leading-tight">Menjaga Tradisi,<br><span class="text-secondary">Membangun Masa Depan</span></h2>
                    <p class="font-body-md text-on-surface-variant leading-relaxed text-lg text-justify">
                        Desa Tulusbesar merupakan desa yang menjunjung tinggi nilai-nilai budaya agraris Javanese. 
                        Masyarakat hidup berdampingan dengan alam, menciptakan lingkungan yang asri dan sejahtera. 
                        Melalui inovasi teknologi, kami berupaya mendigitalkan potensi desa untuk kemajuan bersama tanpa melupakan akar tradisi leluhur.
                    </p>
                    <div class="grid grid-cols-2 gap-md pt-md">
                        <div class="bg-surface-container-low p-lg rounded-2xl border border-surface-dim shadow-sm">
                            <div class="text-tertiary-container font-display-md text-3xl font-bold mb-xs">6.543</div>
                            <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Jiwa Penduduk</div>
                        </div>
                        <div class="bg-surface-container-low p-lg rounded-2xl border border-surface-dim shadow-sm">
                            <div class="text-secondary-container font-display-md text-3xl font-bold mb-xs">4.439</div>
                            <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Km² Area</div>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 bg-secondary/10 rounded-[2rem] transform rotate-3 scale-105 transition-transform duration-500 group-hover:rotate-6"></div>
                    <img src="{{ asset('images/dummy/profil.jpg') }}" alt="Pemandangan Desa" class="relative rounded-[2rem] shadow-2xl w-full h-[500px] object-cover border border-outline-variant/30 transform transition-transform duration-500 group-hover:-translate-y-2">
                </div>
            </div>
        </div>
    </section>

    <!-- WebGIS Preview Section -->
    <section class="py-16 md:py-24 bg-surface-container-low relative">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="text-center max-w-[48rem] mx-auto mb-xl space-y-md">
                <h2 class="font-display-md text-4xl font-bold text-on-background">Peta Cerdas <span class="text-tertiary">Tulusbesar</span></h2>
                <p class="font-body-md text-on-surface-variant text-lg">
                    Sistem Informasi Geografis interaktif yang memetakan potensi wisata, UMKM, fasilitas umum, hingga infrastruktur desa secara akurat dan real-time.
                </p>
            </div>
            
            <div class="relative bg-surface-container-lowest rounded-3xl p-sm shadow-[0_20px_50px_rgba(74,43,29,0.1)] border border-outline-variant/30 overflow-hidden group">
                <div id="home-map" class="w-full h-[400px] md:h-[600px] rounded-[1.25rem] z-10"></div>
                
                <!-- Legend Box Overlay -->
                <div class="absolute top-lg left-lg bg-surface-container-lowest/90 backdrop-blur-md p-md rounded-xl shadow-lg border border-outline-variant/30 hidden md:block z-20">
                    <div class="font-label-md font-bold mb-sm text-on-surface">Kategori Tersedia</div>
                    <div class="space-y-xs">
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-[#8b5cf6]"></span> Fasilitas Umum</div>
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-[#10b981]"></span> Situs Budaya</div>
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-[#3b82f6]"></span> UMKM Desa</div>
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-[#f97316]"></span> Peternakan</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leaflet CSS & JS for Home Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var homeMap = L.map('home-map').setView([-8.0583, 112.7845], 14);

            L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '© Google Maps'
            }).addTo(homeMap);

            var dataUMKM = @json($umkms ?? []);
            var dataCultural = @json($culturalSites ?? []);
            var dataGis = @json($gisFeatures ?? []);

            var umkmIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            var culturalIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            var gisIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            var gisPeternakanIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            var gisFasilitasIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });

            dataUMKM.forEach(function(item) {
                L.marker([item.latitude, item.longitude], {icon: umkmIcon}).addTo(homeMap)
                    .bindPopup("<b>" + item.name + "</b><br>Kategori: UMKM<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
            });
            dataCultural.forEach(function(item) {
                L.marker([item.latitude, item.longitude], {icon: culturalIcon}).addTo(homeMap)
                    .bindPopup("<b>" + item.name + "</b><br>Kategori: Situs Budaya<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
            });
            dataGis.forEach(function(item) {
                var activeIcon = gisIcon;
                if (item.category === 'Peternakan') activeIcon = gisPeternakanIcon;
                else if (item.category === 'Fasilitas Umum') activeIcon = gisFasilitasIcon;
                else if (item.category === 'Situs Budaya') activeIcon = culturalIcon;
                
                L.marker([item.latitude, item.longitude], {icon: activeIcon}).addTo(homeMap)
                    .bindPopup("<b>" + item.name + "</b><br>Kategori: " + item.category + "<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
            });
        });
    </script>

    <!-- Highlight Berita Section -->
    <section class="py-16 md:py-24 bg-background">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-xl">
                <div class="max-w-[42rem] space-y-sm">
                    <h2 class="font-display-md text-4xl font-bold text-on-background">Kabar <span class="text-secondary">Desa</span></h2>
                    <p class="font-body-md text-on-surface-variant text-lg">Ikuti perkembangan terbaru, pengumuman, dan publikasi kegiatan kemasyarakatan Desa Tulusbesar.</p>
                </div>
                <a href="#" class="font-label-md text-secondary hover:text-secondary-fixed-dim transition-colors flex items-center gap-xs">
                    Lihat Semua Berita <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                @php
                    $beritaList = \App\Models\NewsArticle::latest()->take(3)->get();
                @endphp
                @foreach($beritaList as $index => $berita)
                <!-- News Card -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col">
                    <div class="h-56 overflow-hidden relative">
                        @if($index === 0)
                        <div class="absolute top-sm right-sm z-10 bg-tertiary-fixed text-on-tertiary-fixed font-label-sm px-2 py-1 rounded-md shadow-md">Terbaru</div>
                        @endif
                        <img src="{{ Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : Storage::url($berita->image_path) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-lg flex-grow flex flex-col">
                        <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                            <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d M Y') }}</time>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">{{ $berita->title }}</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3 text-justify">{!! strip_tags($berita->content) !!}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Include Footer here to appear at bottom of scrollable area -->
    <x-footer />
</div>
@endsection
