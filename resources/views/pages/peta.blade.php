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
                    <input type="checkbox" checked value="Wisata" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary accent-primary">
                    <div class="w-8 h-8 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">park</span>
                    </div>
                    <span class="font-body-md text-on-surface">Potensi Wisata</span>
                </label>

                <!-- Filter Item 2 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked value="Peternakan" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-secondary focus:ring-secondary accent-secondary">
                    <div class="w-8 h-8 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">pets</span>
                    </div>
                    <span class="font-body-md text-on-surface">Peternakan Warga</span>
                </label>

                <!-- Filter Item 3 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked value="Fasilitas Umum" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-tertiary focus:ring-tertiary accent-tertiary">
                    <div class="w-8 h-8 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">account_balance</span>
                    </div>
                    <span class="font-body-md text-on-surface">Fasilitas Umum & Desa</span>
                </label>

                <!-- Filter Item 4 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked value="PJU" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-[#d97706] focus:ring-[#d97706] accent-[#d97706]">
                    <div class="w-8 h-8 rounded-full bg-[#d97706]/10 text-[#d97706] flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[16px]">lightbulb</span>
                    </div>
                    <span class="font-body-md text-on-surface">PJU Bambu (Penerangan)</span>
                </label>

                <!-- Filter Item 5 -->
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface-variant/30 cursor-pointer transition-colors border border-transparent hover:border-outline-variant/30">
                    <input type="checkbox" checked value="Sampah" class="filter-checkbox w-5 h-5 rounded border-outline-variant text-[#059669] focus:ring-[#059669] accent-[#059669]">
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
    <main class="flex-grow relative bg-surface-variant h-full overflow-hidden z-10">
        <!-- Leaflet CSS and JS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
        
        <!-- Map Container -->
        <div id="map" class="w-full h-full absolute inset-0 z-0"></div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Map pointing to Desa Tulusbesar
                var map = L.map('map').setView([-8.015775, 112.765763], 15);
                
                // Add ArcGIS (Esri) Tile Layer
                L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                    maxZoom: 21,
                    maxNativeZoom: 18,
                    attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ'
                }).addTo(map);

                // Initialize Layer Groups for filtering
                var layerGroups = {
                    'Wisata': L.layerGroup(),
                    'Peternakan': L.layerGroup(),
                    'Fasilitas Umum': L.layerGroup(),
                    'PJU': L.layerGroup(),
                    'Sampah': L.layerGroup()
                };

                // Loop through GIS Features from database
                @if(isset($features) && count($features) > 0)
                    // Helper function to get marker style based on category
                    function getMarkerStyle(category) {
                        switch(category) {
                            case 'Wisata': return { bg: 'bg-primary', border: 'border-t-primary', icon: 'park' };
                            case 'Peternakan': return { bg: 'bg-secondary', border: 'border-t-secondary', icon: 'pets' };
                            case 'Fasilitas Umum': return { bg: 'bg-tertiary', border: 'border-t-tertiary', icon: 'account_balance' };
                            case 'PJU': return { bg: 'bg-[#d97706]', border: 'border-t-[#d97706]', icon: 'lightbulb' };
                            case 'Sampah': return { bg: 'bg-[#059669]', border: 'border-t-[#059669]', icon: 'recycling' };
                            default: return { bg: 'bg-primary', border: 'border-t-primary', icon: 'location_on' };
                        }
                    }

                    @foreach($features as $feature)
                        @if($feature->latitude && $feature->longitude)
                            var lat = parseFloat("{{ str_replace(',', '.', $feature->latitude) }}");
                            var lng = parseFloat("{{ str_replace(',', '.', $feature->longitude) }}");
                            var name = {!! json_encode($feature->name) !!};
                            var category = {!! json_encode($feature->category) !!};
                            var desc = {!! json_encode($feature->description ?? '') !!};
                            
                            var style = getMarkerStyle(category);
                            var iconHtml = `
                                <div class="relative flex flex-col items-center">
                                    <div class="${style.bg} text-white p-2 rounded-full shadow-lg relative z-10 border-2 border-white flex items-center justify-center">
                                        <span class="material-symbols-outlined text-[16px]">${style.icon}</span>
                                    </div>
                                    <div class="w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-t-[8px] ${style.border} -mt-1 relative z-0"></div>
                                </div>
                            `;
                            
                            var customIcon = L.divIcon({
                                html: iconHtml,
                                className: 'bg-transparent',
                                iconSize: [36, 46],
                                iconAnchor: [18, 46],
                                popupAnchor: [0, -46]
                            });

                            var marker = L.marker([lat, lng], {icon: customIcon});
                            marker.bindPopup(`
                                <div class="font-body-sm">
                                    <h4 class="font-bold text-base mb-1">${name}</h4>
                                    <span class="inline-block px-2 py-1 bg-surface-variant text-on-surface-variant text-xs rounded-md mb-2">${category}</span>
                                    <p class="text-sm mt-1">${desc}</p>
                                </div>
                            `);
                            
                            if (layerGroups[category]) {
                                layerGroups[category].addLayer(marker);
                            } else {
                                // Default fallback if category doesn't strictly match
                                marker.addTo(map);
                            }
                        @endif
                    @endforeach
                @endif

                // Handle Checkbox Toggles
                document.querySelectorAll('.filter-checkbox').forEach(function(checkbox) {
                    var category = checkbox.value;
                    
                    // Initial load state based on checkbox
                    if (checkbox.checked && layerGroups[category]) {
                        layerGroups[category].addTo(map);
                    }

                    // Change event
                    checkbox.addEventListener('change', function() {
                        if (this.checked) {
                            layerGroups[category].addTo(map);
                        } else {
                            map.removeLayer(layerGroups[category]);
                        }
                    });
                });
            });
        </script>
    </main>
</div>
@endsection
