@extends('layouts.app')

@section('content')
    <div class="w-full h-[calc(100vh-80px)] flex flex-col md:flex-row overflow-hidden bg-white"
        x-data="{ sidebarOpen: false }">

        <!-- Mobile Sidebar Toggle -->
        <div
            class="md:hidden p-4 bg-white border-b border-gray-200 flex justify-between items-center z-40 shadow-sm relative">
            <h2 class="font-display-md text-xl font-bold text-[#593922]">WebGIS <span
                    class="text-[#8c5a35] font-normal">Tulusbesar</span></h2>
            <button @click="sidebarOpen = !sidebarOpen"
                class="bg-primary/10 text-primary p-2 rounded-lg flex items-center gap-2 transition-colors hover:bg-primary/20">
                <span class="material-symbols-outlined" x-text="sidebarOpen ? 'close' : 'filter_list'">filter_list</span>
            </button>
        </div>

        <!-- Sidebar (Filters & Layers) -->
        <aside
            class="w-full md:w-[320px] lg:w-[380px] bg-white border-r border-gray-200 flex flex-col z-30 shadow-[4px_0_24px_rgba(0,0,0,0.02)] h-[calc(100vh-80px-72px)] md:h-full absolute md:relative top-[72px] md:top-0 transform transition-transform duration-300"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'">

            <div class="p-6 border-b border-gray-100 hidden md:block">
                <h2 class="font-display-md text-2xl font-bold text-[#593922] mb-1">WebGIS <span
                        class="text-[#8c5a35] font-light">Tulusbesar</span></h2>
                <p class="font-body-sm text-gray-500 text-sm">Peta Tata Ruang & Potensi Desa</p>
            </div>

            <div class="p-6 flex-grow overflow-y-auto custom-scrollbar bg-white">
                <h3
                    class="font-label-md font-bold text-gray-800 mb-4 uppercase tracking-wider flex items-center gap-2 text-xs">
                    <span class="material-symbols-outlined text-[18px] text-primary">layers</span> Layer Peta
                </h3>

                <div class="space-y-2">
                    <!-- Filter Item 1 -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-primary/10 text-primary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">park</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">Potensi Wisata</span>
                        <input type="checkbox" checked value="Wisata"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary accent-primary cursor-pointer">
                    </label>

                    <!-- Filter Item UMKM -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-[#4f46e5]/10 text-[#4f46e5] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">storefront</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">UMKM</span>
                        <input type="checkbox" checked value="UMKM"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#4f46e5] focus:ring-[#4f46e5] accent-[#4f46e5] cursor-pointer">
                    </label>

                    <!-- Filter Item 2 -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">pets</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">Peternakan Warga</span>
                        <input type="checkbox" checked value="Peternakan"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-secondary focus:ring-secondary accent-secondary cursor-pointer">
                    </label>

                    <!-- Filter Item 3 -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">account_balance</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">Fasilitas Umum</span>
                        <input type="checkbox" checked value="Fasilitas Umum"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-tertiary focus:ring-tertiary accent-tertiary cursor-pointer">
                    </label>

                    <!-- Filter Item 4 -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-[#d97706]/10 text-[#d97706] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">lightbulb</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">PJU Bambu</span>
                        <input type="checkbox" checked value="PJU"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#d97706] focus:ring-[#d97706] accent-[#d97706] cursor-pointer">
                    </label>

                    <!-- Filter Item 5 -->
                    <label
                        class="flex items-center gap-3 p-3.5 rounded-xl bg-white hover:bg-gray-50 cursor-pointer transition-colors border border-gray-200 shadow-sm">
                        <div
                            class="w-9 h-9 rounded-full bg-[#059669]/10 text-[#059669] flex items-center justify-center shrink-0">
                            <span class="material-symbols-outlined text-[18px]">recycling</span>
                        </div>
                        <span class="font-body-md text-gray-700 font-medium flex-grow">Titik Sampah</span>
                        <input type="checkbox" checked value="Sampah"
                            class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#059669] focus:ring-[#059669] accent-[#059669] cursor-pointer">
                    </label>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100">
                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100/50">
                        <h4 class="font-label-md font-bold text-blue-800 flex items-center gap-2 mb-1 text-sm">
                            <span class="material-symbols-outlined text-[16px]">info</span> Informasi
                        </h4>
                        <p class="font-body-sm text-blue-900/70 text-xs leading-relaxed">Gunakan filter untuk menyaring
                            titik lokasi peta. Data spasial diperbarui secara berkala oleh Pemdes Tulusbesar.</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Map Canvas Area -->
        <main class="flex-grow relative bg-surface-variant h-full overflow-hidden z-10">
            <!-- Leaflet CSS and JS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

            <!-- Leaflet MarkerCluster -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.css" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.4.1/dist/MarkerCluster.Default.css" />
            <script src="https://unpkg.com/leaflet.markercluster@1.4.1/dist/leaflet.markercluster.js"></script>

            <!-- Map Container -->
            <div id="map" class="w-full h-full absolute inset-0 z-0"></div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    // Initialize Map pointing to Desa Tulusbesar
                    var map = L.map('map').setView([-8.0093, 112.7666], 15);

                    // Add ArcGIS (Esri) Tile Layer
                    L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
                        maxZoom: 21,
                        maxNativeZoom: 18,
                        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ'
                    }).addTo(map);

                    // Custom Cluster Icon generator
                    function createCustomClusterIcon(cluster) {
                        var count = cluster.getChildCount();
                        // Tooltip text explanation so users know what the number means
                        var tooltipText = count + " titik lokasi berdekatan. Klik untuk melihat lebih dekat.";

                        return L.divIcon({
                            html: `<div title="${tooltipText}" class="bg-[#8c5a35] text-white font-bold rounded-full border-[3px] border-white shadow-md flex items-center justify-center text-sm hover:bg-[#593922] transition-colors" style="width: 40px; height: 40px;">${count}</div>`,
                            className: 'custom-cluster-icon',
                            iconSize: [40, 40]
                        });
                    }

                    var clusterOptions = {
                        maxClusterRadius: 50,
                        iconCreateFunction: createCustomClusterIcon
                    };

                    // Initialize Layer Groups for filtering (using MarkerClusterGroup to prevent overlapping)
                    var layerGroups = {
                        'Wisata': L.markerClusterGroup(clusterOptions),
                        'Peternakan': L.markerClusterGroup(clusterOptions),
                        'Fasilitas Umum': L.markerClusterGroup(clusterOptions),
                        'PJU': L.markerClusterGroup(clusterOptions),
                        'Sampah': L.markerClusterGroup(clusterOptions),
                        'UMKM': L.markerClusterGroup(clusterOptions)
                    };

                    // Helper function to get marker style based on category
                    function getMarkerStyle(category) {
                        switch (category) {
                            case 'Wisata': return { bg: 'bg-primary', border: 'border-t-primary', icon: 'park' };
                            case 'Peternakan': return { bg: 'bg-secondary', border: 'border-t-secondary', icon: 'pets' };
                            case 'Fasilitas Umum': return { bg: 'bg-tertiary', border: 'border-t-tertiary', icon: 'account_balance' };
                            case 'PJU': return { bg: 'bg-[#d97706]', border: 'border-t-[#d97706]', icon: 'lightbulb' };
                            case 'Sampah': return { bg: 'bg-[#059669]', border: 'border-t-[#059669]', icon: 'recycling' };
                            case 'UMKM': return { bg: 'bg-[#4f46e5]', border: 'border-t-[#4f46e5]', icon: 'storefront' };
                            default: return { bg: 'bg-primary', border: 'border-t-primary', icon: 'location_on' };
                        }
                    }

                    // Loop through GIS Features from database
                    @if(isset($features) && count($features) > 0)
                        @foreach($features as $feature)
                            @if($feature->latitude && $feature->longitude)
                                var lat = parseFloat("{{ str_replace(',', '.', $feature->latitude) }}");
                                var lng = parseFloat("{{ str_replace(',', '.', $feature->longitude) }}");
                                var name = {!! json_encode($feature->name) !!};
                                var category = {!! json_encode($feature->category) !!};
                                var rawDesc = {!! json_encode(strip_tags($feature->description ?? '')) !!};

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

                                var marker = L.marker([lat, lng], { icon: customIcon });
                                marker.bindPopup(`
                                                                <div class="font-body-sm min-w-[220px] max-w-[280px]">
                                                                    <h4 class="font-bold text-base mb-1 text-on-surface">${name}</h4>
                                                                    <span class="inline-block px-2 py-1 bg-surface-variant text-on-surface-variant text-[10px] uppercase tracking-wider font-bold rounded-md mb-2">${category}</span>
                                                                    <div class="max-h-[120px] overflow-y-auto custom-scrollbar mb-4 pr-1">
                                                                        <p class="text-sm mt-1 text-on-surface-variant leading-relaxed">${rawDesc}</p>
                                                                    </div>
                                                                    <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="inline-flex items-center justify-center gap-1 bg-surface-variant !text-primary border border-primary/20 px-3 py-2 rounded-lg text-xs font-bold hover:bg-surface-variant/80 transition-colors w-full text-center">
                                                                        <span class="material-symbols-outlined text-[16px]">directions</span> Rute via Google Maps
                                                                    </a>
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


                    // Loop through Cultural Sites
                    @if(isset($culturalSites) && count($culturalSites) > 0)
                        @foreach($culturalSites as $site)
                            var lat = parseFloat("{{ str_replace(',', '.', $site->latitude) }}");
                            var lng = parseFloat("{{ str_replace(',', '.', $site->longitude) }}");
                            var name = {!! json_encode($site->name) !!};
                            var url = "{{ route('wisata.show', $site->slug) }}";
                            var rawDesc = {!! json_encode(strip_tags($site->description)) !!};
                            var desc = rawDesc.length > 100
                                ? rawDesc.substring(0, 100) + '... <a href="' + url + '" class="!text-primary font-bold hover:underline">Baca selengkapnya</a>'
                                : rawDesc;

                            // force category 'Wisata' for layer group
                            var style = getMarkerStyle('Wisata');
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

                            var marker = L.marker([lat, lng], { icon: customIcon });
                            marker.bindPopup(`
                                                    <div class="font-body-sm min-w-[220px] max-w-[280px]">
                                                        <h4 class="font-bold text-base mb-1 text-on-surface">${name}</h4>
                                                        <span class="inline-block px-2 py-1 bg-surface-variant text-on-surface-variant text-[10px] uppercase tracking-wider font-bold rounded-md mb-2">Situs Budaya</span>
                                                        <p class="text-sm mt-1 mb-4 text-on-surface-variant leading-relaxed">${desc}</p>
                                                        <div class="flex flex-col gap-2">
                                                            <a href="${url}" class="inline-flex items-center justify-center bg-primary !text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-primary/90 transition-colors w-full text-center shadow-sm">Lihat Detail</a>
                                                            <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="inline-flex items-center justify-center gap-1 bg-surface-variant !text-primary border border-primary/20 px-3 py-2 rounded-lg text-xs font-bold hover:bg-surface-variant/80 transition-colors w-full text-center">
                                                                <span class="material-symbols-outlined text-[16px]">directions</span> Rute via Google Maps
                                                            </a>
                                                        </div>
                                                    </div>
                                                `);

                            if (layerGroups['Wisata']) {
                                layerGroups['Wisata'].addLayer(marker);
                            }
                        @endforeach
                    @endif

                    // Loop through UMKMs
                    @if(isset($umkms) && count($umkms) > 0)
                        @foreach($umkms as $umkm)
                            var lat = parseFloat("{{ str_replace(',', '.', $umkm->latitude) }}");
                            var lng = parseFloat("{{ str_replace(',', '.', $umkm->longitude) }}");
                            var name = {!! json_encode($umkm->name) !!};
                            var category = {!! json_encode($umkm->category ?? 'UMKM') !!};
                            var url = "{{ route('umkm.show', $umkm->slug) }}";
                            var rawDesc = {!! json_encode(strip_tags($umkm->description)) !!};
                            var desc = rawDesc.length > 100
                                ? rawDesc.substring(0, 100) + '... <a href="' + url + '" class="!text-primary font-bold hover:underline">Baca selengkapnya</a>'
                                : rawDesc;

                            var style = getMarkerStyle('UMKM');
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

                            var marker = L.marker([lat, lng], { icon: customIcon });
                            marker.bindPopup(`
                                                    <div class="font-body-sm min-w-[220px] max-w-[280px]">
                                                        <h4 class="font-bold text-base mb-1 text-on-surface">${name}</h4>
                                                        <span class="inline-block px-2 py-1 bg-surface-variant text-on-surface-variant text-[10px] uppercase tracking-wider font-bold rounded-md mb-2">${category}</span>
                                                        <p class="text-sm mt-1 mb-4 text-on-surface-variant leading-relaxed">${desc}</p>
                                                        <div class="flex flex-col gap-2">
                                                            <a href="${url}" class="inline-flex items-center justify-center bg-[#4f46e5] !text-white px-3 py-2 rounded-lg text-xs font-bold hover:bg-[#4f46e5]/90 transition-colors w-full text-center shadow-sm">Lihat Detail</a>
                                                            <a href="https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}" target="_blank" class="inline-flex items-center justify-center gap-1 bg-surface-variant !text-[#4f46e5] border border-[#4f46e5]/20 px-3 py-2 rounded-lg text-xs font-bold hover:bg-surface-variant/80 transition-colors w-full text-center">
                                                                <span class="material-symbols-outlined text-[16px]">directions</span> Rute via Google Maps
                                                            </a>
                                                        </div>
                                                    </div>
                                                `);

                            if (layerGroups['UMKM']) {
                                layerGroups['UMKM'].addLayer(marker);
                            }
                        @endforeach
                    @endif

                        // 2. Tampilkan Batas Wilayah Desa Tulusbesar (Sesuai Adaptasi Peta Referensi)
                        var boundaryLayer = L.layerGroup().addTo(map);

                    // Fetch GeoJSON dari file statis yang telah dibuat khusus untuk Desa Tulusbesar
                    var geojsonUrl = '/geojson/batas_desa.geojson?v=' + new Date().getTime();

                    fetch(geojsonUrl)
                        .then(response => {
                            if (!response.ok) throw new Error("File GeoJSON tidak ditemukan");
                            return response.json();
                        })
                        .then(data => {
                            if (data) {
                                var geojsonFeature = L.geoJSON(data, {
                                    style: {
                                        color: '#d97706', // Premium Amber
                                        weight: 4,
                                        opacity: 1,
                                        dashArray: '10, 10',
                                        fillColor: '#8c5a35', // Warm brown 
                                        fillOpacity: 0.15 // Slightly more visible fill
                                    },
                                    onEachFeature: function (feature, layer) {
                                        layer.bindPopup(`<div class="font-body-sm">
                                                <h4 class="font-bold text-base mb-1">Batas Wilayah Administratif</h4>
                                                <p class="text-sm">Desa Tulusbesar, Kec. Tumpang</p>
                                                <p class="text-xs text-on-surface-variant mt-1">Sesuai referensi peta desa</p>
                                            </div>`);
                                    }
                                }).addTo(boundaryLayer);

                                // Arahkan pandangan peta pas di tengah batas wilayah
                                map.fitBounds(geojsonFeature.getBounds(), { padding: [50, 50] });
                            }
                        })
                        .catch(error => {
                            console.error("Gagal memuat batas wilayah: ", error);
                        });

                    // Tambahkan checkbox filter batas wilayah jika diinginkan
                    // layerGroups['Batas Wilayah'] = boundaryLayer;


                    // Handle Checkbox Toggles
                    document.querySelectorAll('.filter-checkbox').forEach(function (checkbox) {
                        var category = checkbox.value;

                        // Initial load state based on checkbox
                        if (checkbox.checked && layerGroups[category]) {
                            layerGroups[category].addTo(map);
                        }

                        // Change event
                        checkbox.addEventListener('change', function () {
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