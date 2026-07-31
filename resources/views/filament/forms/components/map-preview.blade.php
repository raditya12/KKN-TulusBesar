<div
    x-data="{
        lat: $wire.$entangle('data.latitude'),
        lng: $wire.$entangle('data.longitude'),
        map: null,
        marker: null,
        defaultLat: -8.0093, // Pusat Desa Tulusbesar
        defaultLng: 112.7666,
        initMap() {
            if (this.map) {
                this.map.remove();
            }

            const initialLat = this.lat || this.defaultLat;
            const initialLng = this.lng || this.defaultLng;

            this.map = L.map($refs.map).setView([initialLat, initialLng], 16);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(this.map);
            
            if (this.lat && this.lng) {
                this.marker = L.marker([this.lat, this.lng]).addTo(this.map);
            }

            // Menambahkan batas wilayah Desa (garis merah)
            // Sistem akan mencoba mengambil file tulusbesar.geojson di folder public/geojson
            fetch('/geojson/tulusbesar.geojson')
                .then(response => {
                    if (response.ok) return response.json();
                    throw new Error('File GeoJSON batas desa belum tersedia.');
                })
                .then(data => {
                    // Jika file GeoJSON ada, gambar polygon presisi sesuai garis wilayah desa
                    L.geoJSON(data, {
                        style: {
                            color: '#e20613', // Merah
                            weight: 3,
                            dashArray: '5, 5', // Efek putus-putus
                            opacity: 0.8,
                            fillColor: '#e20613',
                            fillOpacity: 0.1
                        }
                    }).addTo(this.map);
                })
                .catch(error => {
                    // File GeoJSON belum ada, jadi kita tidak menampilkan batas desa apapun.
                });

            this.map.on('click', (e) => {
                // Update properties in Alpine, which automatically syncs to Livewire
                this.lat = parseFloat(e.latlng.lat).toFixed(7);
                this.lng = parseFloat(e.latlng.lng).toFixed(7);
                
                if (this.marker) {
                    this.marker.setLatLng(e.latlng);
                } else {
                    this.marker = L.marker(e.latlng).addTo(this.map);
                }
            });
        }
    }"
    x-init="
        if (typeof L === 'undefined') {
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
            document.head.appendChild(link);
            
            const script = document.createElement('script');
            script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
            script.onload = () => initMap();
            document.head.appendChild(script);
        } else {
            initMap();
        }
    "
    wire:ignore
>
    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 flex justify-between items-center">
        <span>📍 Klik area pada peta untuk menentukan otomatis titik lokasi koordinat.</span>
        <button type="button" 
            @click="lat = null; lng = null; if(marker) { map.removeLayer(marker); marker = null; }; map.setView([defaultLat, defaultLng], 16)" 
            class="text-xs text-primary-600 hover:underline dark:text-primary-400">
            Reset Peta
        </button>
    </div>
    <div x-ref="map" style="height: 350px; width: 100%; border-radius: 0.5rem; z-index: 1;" class="border border-gray-300 dark:border-gray-700"></div>
</div>
