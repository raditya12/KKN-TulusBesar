<div class="mt-4" x-data x-init="
    if (typeof L === 'undefined') {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css';
        document.head.appendChild(link);
        
        const script = document.createElement('script');
        script.src = 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js';
        script.onload = () => { initFilamentMap() };
        document.head.appendChild(script);
    } else {
        setTimeout(initFilamentMap, 100);
    }

    function initFilamentMap() {
        var mapEl = document.getElementById('filament-map-picker');
        if(!mapEl || mapEl._leaflet_id) return; // Prevent double init
        
        var latInput = document.getElementById('latitude');
        var lngInput = document.getElementById('longitude');
        
        // Default to Tulusbesar village coordinates
        var defaultLat = latInput && latInput.value ? parseFloat(latInput.value) : -8.015775;
        var defaultLng = lngInput && lngInput.value ? parseFloat(lngInput.value) : 112.765763;
        
        var map = L.map('filament-map-picker').setView([defaultLat, defaultLng], 15);
        
        L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 21,
            maxNativeZoom: 18,
            attribution: 'Tiles &copy; Esri &mdash; Source: Esri, DeLorme, NAVTEQ'
        }).addTo(map);
        
        var marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);
        
        function updateInputs(lat, lng) {
            if(latInput && lngInput) {
                latInput.value = lat;
                lngInput.value = lng;
                // Trigger Livewire sync
                latInput.dispatchEvent(new Event('input', { bubbles: true }));
                lngInput.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
        
        marker.on('dragend', function (e) {
            var position = marker.getLatLng();
            updateInputs(position.lat.toFixed(8), position.lng.toFixed(8));
        });
        
        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            updateInputs(e.latlng.lat.toFixed(8), e.latlng.lng.toFixed(8));
        });

        // Listen for manual typed input
        if(latInput && lngInput) {
            latInput.addEventListener('change', function() {
                var lat = parseFloat(this.value);
                var lng = parseFloat(lngInput.value);
                if(lat && lng) {
                    marker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                }
            });
            lngInput.addEventListener('change', function() {
                var lat = parseFloat(latInput.value);
                var lng = parseFloat(this.value);
                if(lat && lng) {
                    marker.setLatLng([lat, lng]);
                    map.panTo([lat, lng]);
                }
            });
        }
    }
" wire:ignore>
    <div class="mb-2 flex items-center justify-between">
        <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">Preview Peta (Klik atau geser pin biru)</span>
    </div>
    <div id="filament-map-picker" class="rounded-xl border border-gray-300 dark:border-white/10"
        style="height: 400px; width: 100%; z-index: 1;"></div>
</div>