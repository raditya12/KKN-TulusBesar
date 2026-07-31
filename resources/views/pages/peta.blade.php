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
            <!-- Search Bar -->
            <div class="mb-6 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-gray-400">search</span>
                </div>
                <input type="text" id="searchInput" placeholder="Cari nama lokasi..." class="w-full pl-10 pr-4 py-2 border border-outline-variant/50 rounded-xl focus:ring-primary focus:border-primary bg-surface text-sm transition-shadow shadow-sm focus:shadow-md">
            </div>

            <h3 class="font-label-md font-bold text-on-surface mb-4 uppercase tracking-wider flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">layers</span> Layer Aktif
            </h3>

            <div class="space-y-4" id="categoryFilters">
                @foreach($categories as $category)
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked value="{{ $category->name }}" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-[{{ $category->color }}] focus:ring-[{{ $category->color }}] accent-[{{ $category->color }}]" style="accent-color: {{ $category->color }};">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0" style="background-color: {{ $category->color }}20; color: {{ $category->color }};">
                        <span class="material-symbols-outlined text-[16px]">{{ $category->icon }}</span>
                    </div>
                    <span class="font-body-md text-on-surface">{{ $category->name }}</span>
                </label>
                @endforeach
            </div>
            
            <div class="mt-8 pt-6 border-t border-outline-variant/30">
                <div class="bg-primary-container/10 p-4 rounded-xl border border-primary/20">
                    <h4 class="font-label-md font-bold text-primary flex items-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-[18px]">info</span> Status Integrasi
                    </h4>
                    <p class="font-body-sm text-on-surface-variant">Peta interaktif ini dilengkapi dengan fitur pencarian lokasi dan mode lacak GPS untuk pengunjung secara langsung.</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Map Canvas Area -->
    <main class="flex-grow relative bg-surface-variant h-full overflow-hidden z-10">
        <!-- Leaflet CSS and JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
        <!-- Leaflet MarkerCluster CSS and JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css" />
        <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>
        
        <!-- Map Container -->
        <div id="map" class="w-full h-full absolute inset-0 z-0"></div>

        <!-- Custom Controls Overlay -->
        <div class="absolute bottom-6 right-6 z-[400] flex flex-col gap-2">
            <button id="btnLocate" class="bg-white text-primary p-3 rounded-full shadow-lg hover:bg-gray-50 transition-colors flex items-center justify-center" title="Lokasi Saya">
                <span class="material-symbols-outlined">my_location</span>
            </button>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Map pointing to Desa Tulusbesar
                var map = L.map('map', {zoomControl: false}).setView([-8.015775, 112.765763], 15);
                
                L.control.zoom({
                    position: 'topright'
                }).addTo(map);

                // Add ArcGIS (Esri) Tile Layer
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 21,
                    maxNativeZoom: 18,
                    attribution: 'Tiles &copy; Esri'
                }).addTo(map);

                // GeoJSON border removed based on user request

                // Initialize Layer Groups dynamically
                var layerGroups = {};
                var categoriesData = @json($categories);
                categoriesData.forEach(function(cat) {
                    layerGroups[cat.name] = L.markerClusterGroup({ chunkedLoading: true });
                });

                var allMarkers = [];

                @if(isset($features) && count($features) > 0)
                    @foreach($features as $feature)
                        @if($feature->latitude && $feature->longitude && $feature->locationCategory)
                            var lat = parseFloat("{{ str_replace(',', '.', $feature->latitude) }}");
                            var lng = parseFloat("{{ str_replace(',', '.', $feature->longitude) }}");
                            var name = {!! json_encode($feature->name) !!};
                            var categoryName = {!! json_encode($feature->locationCategory->name) !!};
                            var catColor = {!! json_encode($feature->locationCategory->color) !!};
                            var catIcon = {!! json_encode($feature->locationCategory->icon) !!};
                            var desc = {!! json_encode($feature->description ?? '') !!};
                            var shortUrl = {!! json_encode($feature->short_url ?? '') !!};
                            var whatsapp = {!! json_encode($feature->whatsapp_number ?? '') !!};
                            
                            var iconHtml = `
                                <div class="relative flex flex-col items-center">
                                    <div style="background-color: ${catColor}; border-color: white;" class="text-white p-2 rounded-full shadow-lg relative z-10 border-2 flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">${catIcon}</span>
                                    </div>
                                    <div class="w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-t-[8px] -mt-1 relative z-0" style="border-top-color: ${catColor};"></div>
                                </div>
                            `;
                            
                            var customIcon = L.divIcon({
                                html: iconHtml,
                                className: 'bg-transparent',
                                iconSize: [36, 46],
                                iconAnchor: [18, 46],
                                popupAnchor: [0, -46]
                            });

                            var marker = L.marker([lat, lng], {icon: customIcon, title: name});
                            allMarkers.push({marker: marker, name: name, category: categoryName});
                            
                            var popupContent = `
                                <div class="font-sans w-64 flex flex-col gap-2 pt-1">
                                    <div class="flex flex-col gap-1 border-b border-gray-100 pb-2">
                                        <h4 class="font-bold text-lg leading-tight text-gray-900 m-0" style="margin: 0;">${name}</h4>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            <span class="material-symbols-outlined text-[14px]" style="color: ${catColor}">${catIcon}</span>
                                            <span class="text-xs font-semibold uppercase tracking-wide" style="color: ${catColor}">${categoryName}</span>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-snug mt-1 mb-2 line-clamp-3">${desc ? desc.substring(0, 120) + (desc.length > 120 ? '...' : '') : '<i class="text-gray-400">Tidak ada deskripsi</i>'}</p>
                                    
                                    <div class="flex gap-2 w-full mt-1">
                                        <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" style="color: white !important; text-decoration: none;" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg flex justify-center items-center gap-1 transition-all shadow-sm text-sm">
                                            <span class="material-symbols-outlined text-[16px]">directions</span> Rute
                                        </a>
                                        ${whatsapp ? `
                                        <a href="https://wa.me/${whatsapp}" target="_blank" style="color: white !important; text-decoration: none;" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-2 rounded-lg flex justify-center items-center gap-1 transition-all shadow-sm text-sm">
                                            <span class="material-symbols-outlined text-[16px]">chat</span> Chat
                                        </a>
                                        ` : ''}
                                        <a href="/wisata/${{!! json_encode($feature->slug ?? '') !!}}" style="color: white !important; text-decoration: none;" class="bg-gray-800 hover:bg-gray-900 text-white font-medium py-2 px-3 rounded-lg flex justify-center items-center transition-all shadow-sm">
                                            <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                                        </a>
                                    </div>
                                </div>
                            `;
                            
                            marker.bindPopup(popupContent);
                            
                            if (layerGroups[categoryName]) {
                                layerGroups[categoryName].addLayer(marker);
                            }
                        @endif
                    @endforeach
                @endif

                // Handle Checkbox Toggles & Add Initial Layers
                document.querySelectorAll('.filter-checkbox').forEach(function(checkbox) {
                    var category = checkbox.value;
                    if (checkbox.checked && layerGroups[category]) {
                        map.addLayer(layerGroups[category]);
                    }
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            map.addLayer(layerGroups[category]);
                        } else {
                            map.removeLayer(layerGroups[category]);
                        }
                    });
                });

                // Search Bar Logic
                var searchInput = document.getElementById('searchInput');
                searchInput.addEventListener('input', function(e) {
                    var query = e.target.value.toLowerCase();
                    
                    // Clear all layers first
                    for (var cat in layerGroups) {
                        layerGroups[cat].clearLayers();
                    }

                    // Re-add markers that match the search (and whose category is checked)
                    allMarkers.forEach(function(item) {
                        var checkbox = document.querySelector(`.filter-checkbox[value="${item.category}"]`);
                        if (checkbox && checkbox.checked && item.name.toLowerCase().includes(query)) {
                            layerGroups[item.category].addLayer(item.marker);
                        }
                    });
                });

                // User Location (GPS Tracking)
                var locateBtn = document.getElementById('btnLocate');
                var userMarker = null;
                var userCircle = null;

                locateBtn.addEventListener('click', function() {
                    locateBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span>';
                    map.locate({setView: true, maxZoom: 16});
                });

                map.on('locationfound', function(e) {
                    var radius = e.accuracy / 2;
                    locateBtn.innerHTML = '<span class="material-symbols-outlined">my_location</span>';
                    locateBtn.classList.add('bg-primary', 'text-white');
                    locateBtn.classList.remove('bg-white', 'text-primary');

                    if (userMarker) {
                        map.removeLayer(userMarker);
                        map.removeLayer(userCircle);
                    }

                    var userIcon = L.divIcon({
                        html: '<div class="w-4 h-4 bg-blue-500 rounded-full border-2 border-white shadow-md shadow-blue-500/50 relative"><div class="absolute inset-0 bg-blue-500 rounded-full animate-ping opacity-75"></div></div>',
                        className: 'bg-transparent',
                        iconSize: [16, 16],
                        iconAnchor: [8, 8]
                    });

                    userMarker = L.marker(e.latlng, {icon: userIcon}).addTo(map)
                        .bindPopup("Anda berada dalam radius " + radius.toFixed(0) + " meter dari titik ini.").openPopup();
                    userCircle = L.circle(e.latlng, radius, {
                        color: '#3b82f6',
                        fillColor: '#3b82f6',
                        fillOpacity: 0.15,
                        weight: 1
                    }).addTo(map);
                });

                map.on('locationerror', function(e) {
                    locateBtn.innerHTML = '<span class="material-symbols-outlined">my_location</span>';
                    alert(e.message);
                });
            });
        </script>
    </main>
</div>
@endsection
