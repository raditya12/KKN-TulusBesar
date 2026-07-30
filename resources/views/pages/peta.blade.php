@extends('layouts.app')

@section('content')
<div class="w-full h-[calc(100vh-80px)] flex flex-col md:flex-row overflow-hidden relative" x-data="{ sidebarOpen: false }">
    
    <!-- Mobile Sidebar Toggle -->
    <div class="md:hidden absolute top-4 left-4 z-40">
        <button @click="sidebarOpen = !sidebarOpen" class="bg-primary-container text-on-primary-container p-2 rounded-lg shadow-lg border border-outline-variant/30 flex items-center gap-2">
            <span class="material-symbols-outlined" x-text="sidebarOpen ? 'close' : 'filter_list'">filter_list</span>
            <span class="font-label-md font-bold">Filter Peta</span>
        </button>
    </div>

    <!-- Sidebar (Filters & Layers) -->
    <aside class="w-full md:w-[320px] lg:w-[380px] bg-surface-container-lowest border-r border-outline-variant/50 flex flex-col z-30 shadow-xl md:shadow-none h-full absolute md:relative transform transition-transform duration-300"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">
        
        <div class="p-6 border-b border-outline-variant/30 mt-12 md:mt-0">
            <h2 class="font-display-md text-2xl font-bold text-on-surface mb-2">WebGIS <span class="text-secondary">Tulusbesar</span></h2>
            <p class="font-body-sm text-on-surface-variant">Sistem pemetaan pintar (Geographic Information System) untuk tata ruang dan potensi desa.</p>
        </div>

        <div class="p-6 flex-grow overflow-y-auto custom-scrollbar">
            <h3 class="font-label-md font-bold text-on-surface mb-4 uppercase tracking-wider flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">layers</span> Layer Aktif
            </h3>

            <div class="space-y-4">
                <!-- Filter Item 1 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary accent-primary">
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">park</span>
                    </div>
                    <span class="font-body-md text-on-surface">Potensi Wisata</span>
                </label>

                <!-- Filter Item 2 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked class="w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary accent-secondary">
                    <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">pets</span>
                    </div>
                    <span class="font-body-md text-on-surface">Peternakan Warga</span>
                </label>

                <!-- Filter Item 3 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked class="w-5 h-5 rounded border-outline-variant text-tertiary focus:ring-tertiary accent-tertiary">
                    <div class="w-8 h-8 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">account_balance</span>
                    </div>
                    <span class="font-body-md text-on-surface">Fasilitas Umum & Desa</span>
                </label>

                <!-- Filter Item 4 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" class="w-5 h-5 rounded border-outline-variant text-[#d97706] focus:ring-[#d97706] accent-[#d97706]">
                    <div class="w-8 h-8 rounded-full bg-[#d97706]/10 text-[#d97706] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">lightbulb</span>
                    </div>
                    <span class="font-body-md text-on-surface">PJU Bambu (Penerangan)</span>
                </label>

                <!-- Filter Item 5 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" class="w-5 h-5 rounded border-outline-variant text-[#059669] focus:ring-[#059669] accent-[#059669]">
                    <div class="w-8 h-8 rounded-full bg-[#059669]/10 text-[#059669] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">recycling</span>
                    </div>
                    <span class="font-body-md text-on-surface">Titik Pengelolaan Sampah</span>
                </label>
            </div>
            
            <div class="mt-8 pt-6 border-t border-outline-variant/30">
                <div class="bg-primary-container/10 p-4 rounded-xl border border-primary/20">
                    <h4 class="font-label-md font-bold text-primary flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-[18px]">info</span> Status Integrasi
                    </h4>
                    <p class="font-body-sm text-on-surface-variant">Peta ini menggunakan data spasial satelit resolusi tinggi. Fitur interaktif masih dalam mode pratinjau (dummy).</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Map Canvas Area -->
    <main class="flex-grow relative bg-surface-variant h-full overflow-hidden" id="map">
    </main>
</div>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var map = L.map('map').setView([-8.0583, 112.7845], 14);

        // Google Maps Standard Layer
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '© Google Maps'
        }).addTo(map);

        var dataUMKM = @json($umkms ?? []);
        var dataCultural = @json($culturalSites ?? []);
        var dataGis = @json($gisFeatures ?? []);

        var umkmIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var culturalIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var gisIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var gisPeternakanIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        var gisFasilitasIcon = L.icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-violet.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        dataUMKM.forEach(function(item) {
            L.marker([item.latitude, item.longitude], {icon: umkmIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: UMKM<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
        });

        dataCultural.forEach(function(item) {
            L.marker([item.latitude, item.longitude], {icon: culturalIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: Situs Budaya<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
        });

        dataGis.forEach(function(item) {
            var activeIcon = gisIcon;
            if (item.category === 'Peternakan') activeIcon = gisPeternakanIcon;
            else if (item.category === 'Fasilitas Umum') activeIcon = gisFasilitasIcon;
            else if (item.category === 'Situs Budaya') activeIcon = culturalIcon;

            L.marker([item.latitude, item.longitude], {icon: activeIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: " + item.category + "<br>Lat: " + item.latitude + ", Lng: " + item.longitude + "<br>" + (item.description || ""));
        });
    });
</script>
@endsection
