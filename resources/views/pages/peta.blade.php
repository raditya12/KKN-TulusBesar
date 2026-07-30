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
    <main class="flex-grow relative bg-surface-variant h-full overflow-hidden">
        <!-- Dummy Map Background Image -->
        <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=2000&auto=format&fit=crop" alt="Peta Desa Tulusbesar" class="w-full h-full object-cover filter contrast-125 saturate-50 sepia-[0.3]">
        
        <!-- Map Overlay UI Controls -->
        <div class="absolute top-4 right-4 z-20 flex flex-col gap-2 hidden md:flex">
            <button class="w-10 h-10 bg-surface-container-lowest text-on-surface rounded-lg shadow-md border border-outline-variant/30 flex items-center justify-center hover:bg-surface-variant transition-colors" title="Zoom In">
                <span class="material-symbols-outlined">add</span>
            </button>
            <button class="w-10 h-10 bg-surface-container-lowest text-on-surface rounded-lg shadow-md border border-outline-variant/30 flex items-center justify-center hover:bg-surface-variant transition-colors" title="Zoom Out">
                <span class="material-symbols-outlined">remove</span>
            </button>
            <button class="w-10 h-10 bg-surface-container-lowest text-on-surface rounded-lg shadow-md border border-outline-variant/30 flex items-center justify-center mt-2 hover:bg-surface-variant transition-colors" title="Lokasi Saat Ini">
                <span class="material-symbols-outlined">my_location</span>
            </button>
        </div>

        <!-- Dummy Map Markers -->
        <!-- Marker 1 (Wisata) -->
        <div class="absolute top-1/3 left-1/3 z-20 transform -translate-x-1/2 -translate-y-full group cursor-pointer">
            <div class="relative flex flex-col items-center">
                <div class="bg-primary text-on-primary p-2 rounded-full shadow-lg map-pin-active relative z-10 border-2 border-white">
                    <span class="material-symbols-outlined text-[20px]">park</span>
                </div>
                <div class="w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-t-[8px] border-t-primary -mt-1 relative z-0"></div>
                
                <!-- Tooltip Popup -->
                <div class="absolute bottom-full mb-2 bg-surface-container-lowest p-3 rounded-xl shadow-xl border border-outline-variant/30 w-48 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-30">
                    <img src="https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=300&auto=format&fit=crop" class="w-full h-20 object-cover rounded-lg mb-2" alt="Coban">
                    <h4 class="font-label-md font-bold text-on-surface">Coban Tulus</h4>
                    <p class="font-body-sm text-on-surface-variant text-[11px]">Wisata Alam</p>
                </div>
            </div>
        </div>

        <!-- Marker 2 (Budaya) -->
        <div class="absolute top-1/2 left-2/3 z-20 transform -translate-x-1/2 -translate-y-full group cursor-pointer">
            <div class="relative flex flex-col items-center">
                <div class="bg-tertiary text-on-tertiary p-2 rounded-full shadow-lg relative z-10 border-2 border-white">
                    <span class="material-symbols-outlined text-[20px]">account_balance</span>
                </div>
                <div class="w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-t-[8px] border-t-tertiary -mt-1 relative z-0"></div>
                
                <!-- Tooltip Popup -->
                <div class="absolute bottom-full mb-2 bg-surface-container-lowest p-3 rounded-xl shadow-xl border border-outline-variant/30 w-48 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none z-30">
                    <h4 class="font-label-md font-bold text-on-surface">Kantor Desa Tulusbesar</h4>
                    <p class="font-body-sm text-on-surface-variant text-[11px]">Fasilitas Umum</p>
                </div>
            </div>
        </div>

        <!-- Marker 3 (Peternakan) -->
        <div class="absolute bottom-1/3 left-1/2 z-20 transform -translate-x-1/2 -translate-y-full group cursor-pointer">
            <div class="relative flex flex-col items-center">
                <div class="bg-secondary text-on-primary p-2 rounded-full shadow-lg relative z-10 border-2 border-white">
                    <span class="material-symbols-outlined text-[20px]">pets</span>
                </div>
                <div class="w-0 h-0 border-l-[6px] border-l-transparent border-r-[6px] border-r-transparent border-t-[8px] border-t-secondary -mt-1 relative z-0"></div>
            </div>
        </div>
        
        <!-- Legend (Bottom Left) -->
        <div class="absolute bottom-4 left-4 z-20 bg-surface-container-lowest/90 backdrop-blur-sm p-3 rounded-xl shadow-md border border-outline-variant/30 hidden md:block">
            <div class="font-label-sm font-bold text-on-surface mb-2">Legenda Peta</div>
            <div class="grid grid-cols-2 gap-x-4 gap-y-1">
                <div class="flex items-center gap-1 font-body-sm text-xs"><span class="w-3 h-3 rounded-full bg-primary"></span> Wisata</div>
                <div class="flex items-center gap-1 font-body-sm text-xs"><span class="w-3 h-3 rounded-full bg-secondary"></span> Ternak</div>
                <div class="flex items-center gap-1 font-body-sm text-xs"><span class="w-3 h-3 rounded-full bg-tertiary"></span> F. Umum</div>
                <div class="flex items-center gap-1 font-body-sm text-xs"><span class="w-3 h-3 rounded-full bg-[#d97706]"></span> PJU</div>
            </div>
        </div>
    </main>
</div>
@endsection
