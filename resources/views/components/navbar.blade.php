@php
    // Desktop Classes
    $activeDesktop = "text-tertiary-fixed font-bold border-b-2 border-tertiary-fixed pb-1 hover:bg-primary/10 transition-all duration-200 px-md py-sm font-label-md text-label-md";
    $inactiveDesktop = "text-on-primary-container/80 hover:text-tertiary-fixed transition-colors hover:bg-primary/10 transition-all duration-200 px-md py-sm rounded-lg font-label-md text-label-md";
    
    // Mobile Classes
    $activeMobile = "text-tertiary-fixed font-bold bg-primary/10 px-md py-sm rounded-lg font-label-md transition-colors";
    $inactiveMobile = "text-on-primary-container hover:text-tertiary-fixed hover:bg-primary/10 px-md py-sm rounded-lg font-label-md transition-colors";
@endphp

<header x-data="{ mobileMenuOpen: false }" class="bg-primary-container/80 backdrop-blur-md dark:bg-primary-container/90 top-0 sticky z-50 border-b border-outline-variant/30 shadow-md shadow-primary/5 w-full">
    <div class="max-w-screen-2xl mx-auto px-4 md:px-container-margin py-3 flex justify-between items-center w-full">
        <div class="font-display-md text-2xl md:text-3xl font-bold text-on-primary-container flex items-center gap-2 md:gap-3">
            <div class="flex-shrink-0 bg-white rounded-full flex items-center justify-center p-0.5 shadow-sm h-8 w-8 md:h-10 md:w-10 overflow-hidden">
                <img src="{{ asset('images/logo desa.jpeg') }}" alt="Logo Desa Tulusbesar" class="w-full h-full object-contain">
            </div>
            <span>Tulusbesar</span>
        </div>
        
        <!-- Navigation - Hidden on mobile -->
        <nav class="hidden md:flex items-center gap-lg">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $activeDesktop : $inactiveDesktop }}">
                Beranda
            </a>
            <a href="{{ route('sejarah') }}" class="{{ request()->routeIs('sejarah') ? $activeDesktop : $inactiveDesktop }}">
                Sejarah
            </a>
            <a href="{{ route('wisata') }}" class="{{ request()->routeIs('wisata') ? $activeDesktop : $inactiveDesktop }}">
                Wisata & Budaya
            </a>
            <a href="{{ route('umkm') }}" class="{{ request()->routeIs('umkm') ? $activeDesktop : $inactiveDesktop }}">
                Potensi UMKM
            </a>
            <a href="{{ route('peta') }}" class="{{ request()->routeIs('peta') ? $activeDesktop : $inactiveDesktop }}">
                Peta Interaktif (WebGIS)
            </a>
            <a href="{{ route('publikasi') }}" class="{{ request()->routeIs('publikasi') ? $activeDesktop : $inactiveDesktop }}">
                Publikasi & Informasi
            </a>
        </nav>
        
        <!-- Mobile Menu Trigger -->
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden text-on-primary-container p-sm focus:outline-none">
            <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
        </button>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         @click.away="mobileMenuOpen = false"
         class="md:hidden absolute top-full left-0 w-full bg-primary-container/95 backdrop-blur-xl border-b border-outline-variant/30 shadow-lg"
         style="display: none;">
        <nav class="flex flex-col p-md gap-sm">
            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? $activeMobile : $inactiveMobile }}">
                Beranda
            </a>
            <a href="{{ route('sejarah') }}" class="{{ request()->routeIs('sejarah') ? $activeMobile : $inactiveMobile }}">
                Sejarah
            </a>
            <a href="{{ route('wisata') }}" class="{{ request()->routeIs('wisata') ? $activeMobile : $inactiveMobile }}">
                Wisata & Budaya
            </a>
            <a href="{{ route('umkm') }}" class="{{ request()->routeIs('umkm') ? $activeMobile : $inactiveMobile }}">
                Potensi UMKM
            </a>
            <a href="{{ route('peta') }}" class="{{ request()->routeIs('peta') ? $activeMobile : $inactiveMobile }}">
                Peta Interaktif (WebGIS)
            </a>
            <a href="{{ route('publikasi') }}" class="{{ request()->routeIs('publikasi') ? $activeMobile : $inactiveMobile }}">
                Publikasi & Informasi
            </a>
        </nav>
    </div>
</header>
