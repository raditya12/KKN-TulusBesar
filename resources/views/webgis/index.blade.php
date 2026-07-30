<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebGIS - Desa Tulusbesar</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #map { height: 100vh; width: 100%; }
        body { margin: 0; padding: 0; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="bg-blue-600 p-4 text-white shadow-lg flex justify-between items-center absolute top-0 w-full z-[1000]">
        <div class="text-xl font-bold">WebGIS Desa Tulusbesar</div>
        <div class="space-x-4">
            <a href="/" class="hover:underline">Home</a>
            <a href="/tutorials" class="hover:underline">Inovasi</a>
            <a href="/admin" class="hover:underline">Admin</a>
        </div>
    </nav>

    <!-- Map Container -->
    <div id="map" class="pt-16"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        // Koordinat tengah desa tulusbesar (perkiraan)
        var map = L.map('map').setView([-8.0583, 112.7845], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var dataUMKM = @json($umkms);
        var dataCultural = @json($culturalSites);
        var dataGis = @json($gisFeatures);

        // Icon custom untuk membedakan
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

        dataUMKM.forEach(function(item) {
            L.marker([item.latitude, item.longitude], {icon: umkmIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: UMKM<br>" + (item.description || ""));
        });

        dataCultural.forEach(function(item) {
            L.marker([item.latitude, item.longitude], {icon: culturalIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: Wisata/Budaya<br>" + (item.description || ""));
        });

        dataGis.forEach(function(item) {
            L.marker([item.latitude, item.longitude], {icon: gisIcon}).addTo(map)
                .bindPopup("<b>" + item.name + "</b><br>Kategori: " + item.category + "<br>" + (item.description || ""));
        });
    </script>
</body>
</html>
