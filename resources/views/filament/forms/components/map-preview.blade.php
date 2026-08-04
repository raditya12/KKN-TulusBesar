<div x-data="{
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

            // Fix broken marker image by specifying icon URLs directly
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon-2x.png',
                iconUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
            });

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

            // Custom Reset Button Control below zoom
            const ResetControl = L.Control.extend({
                options: {
                    position: 'topleft'
                },
                onAdd: () => {
                    const container = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
                    container.innerHTML = `<a href='#' title='Reset Peta' role='button' aria-label='Reset Peta'
    style='display: flex; justify-content: center; align-items: center; color: #4b5563; text-decoration: none; width: 30px; height: 30px; background-color: white;'>
    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='none' viewBox='0 0 24 24' stroke-width='2'
        stroke='currentColor'>
        <path stroke-linecap='round' stroke-linejoin='round'
            d='M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99' />
    </svg></a>`;

    L.DomEvent.on(container, 'click', L.DomEvent.stopPropagation)
    .on(container, 'click', L.DomEvent.preventDefault)
    .on(container, 'click', () => {
    this.lat = null;
    this.lng = null;
    if (this.marker) {
    this.map.removeLayer(this.marker);
    this.marker = null;
    }
    this.map.setView([this.defaultLat, this.defaultLng], 16);
    });

    // Hover effects to match leaflet style
    container.onmouseover = function(){ container.querySelector('a').style.backgroundColor = '#f4f4f4'; }
    container.onmouseout = function(){ container.querySelector('a').style.backgroundColor = 'white'; }

    return container;
    }
    });
    this.map.addControl(new ResetControl());
    }
    }" x-init="
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
    " wire:ignore>
    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 flex justify-between items-center">
        <span>📍 Klik area pada peta untuk menentukan otomatis titik lokasi koordinat.</span>
    </div>
    <div x-ref="map" style="height: 350px; width: 100%; border-radius: 0.5rem; z-index: 1;"
        class="border border-gray-300 dark:border-gray-700"></div>
</div>