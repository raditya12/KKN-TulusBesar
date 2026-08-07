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
            L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
                maxZoom: 20,
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                attribution: '© Google Maps'
            }).addTo(this.map);
            
            if (this.lat && this.lng) {
                this.marker = L.marker([this.lat, this.lng]).addTo(this.map);
            }

            this.$watch('lat', value => {
                if (value && this.lng && this.map) {
                    let pos = [parseFloat(value), parseFloat(this.lng)];
                    if (this.marker) this.marker.setLatLng(pos);
                    else this.marker = L.marker(pos).addTo(this.map);
                    this.map.panTo(pos);
                }
            });

            this.$watch('lng', value => {
                if (value && this.lat && this.map) {
                    let pos = [parseFloat(this.lat), parseFloat(value)];
                    if (this.marker) this.marker.setLatLng(pos);
                    else this.marker = L.marker(pos).addTo(this.map);
                    this.map.panTo(pos);
                }
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
    
    // Add Geocoder Search Box
    if (typeof L.Control.Geocoder !== 'undefined') {
        const arcgisProvider = L.Control.Geocoder.arcgis();
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            position: 'topright',
            placeholder: 'Cari lokasi...',
            geocoder: arcgisProvider
        }).addTo(this.map);
        
        geocoder.on('markgeocode', (e) => {
            const latlng = e.geocode.center;
            
            // Update properties in Alpine, which automatically syncs to Livewire
            this.lat = parseFloat(latlng.lat).toFixed(7);
            this.lng = parseFloat(latlng.lng).toFixed(7);
            
            if (this.marker) {
                this.marker.setLatLng(latlng);
            } else {
                this.marker = L.marker(latlng).addTo(this.map);
            }
            
            this.map.fitBounds(e.geocode.bbox);
        });
    }
    }
    }" x-init="
    const loadMapAndGeocoder = () => {
        if (typeof L.Control === 'undefined' || typeof L.Control.Geocoder === 'undefined') {
            const geoLink = document.createElement('link');
            geoLink.rel = 'stylesheet';
            geoLink.href = 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css';
            document.head.appendChild(geoLink);

            const geoScript = document.createElement('script');
            geoScript.src = 'https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js';
            geoScript.onload = () => initMap();
            document.head.appendChild(geoScript);
        } else {
            initMap();
        }
    };

    if (typeof L === 'undefined') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(link);

        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = () => loadMapAndGeocoder();
        document.head.appendChild(script);
    } else {
        loadMapAndGeocoder();
    }
    " wire:ignore>
    <div class="mb-2 text-sm text-gray-500 dark:text-gray-400 flex justify-between items-center">
        <span>📍 Klik area pada peta untuk menentukan otomatis titik lokasi koordinat.</span>
    </div>
    <div x-ref="map" style="height: 350px; width: 100%; border-radius: 0.5rem; z-index: 1;"
        class="border border-gray-300 dark:border-gray-700"></div>
</div>