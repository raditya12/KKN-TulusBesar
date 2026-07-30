@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1552554792-5eb329a2862b?q=80&w=2000&auto=format&fit=crop')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent"></div>
        </div>

        <!-- Hero Content -->
        <div class="relative z-10 text-center px-container-margin max-w-[56rem] mx-auto flex flex-col items-center gap-lg">
            <span class="px-md py-xs rounded-full bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md tracking-wider uppercase text-sm shadow-xl shadow-primary/20">
                Selamat Datang di
            </span>
            <h1 class="font-display-lg text-[clamp(40px,8vw,80px)] leading-tight text-on-primary font-bold drop-shadow-lg">
                Desa Tulusbesar
            </h1>
            <p class="font-body-lg text-lg md:text-xl text-on-primary/90 max-w-[42rem] drop-shadow-md">
                Harmoni kearifan lokal Javanese dan inovasi tata kelola cerdas dalam satu genggaman. Jelajahi keindahan budaya dan infrastruktur desa kami.
            </p>
            
            <div class="flex flex-wrap items-center justify-center gap-md mt-md">
                <a href="#" class="bg-tertiary-fixed hover:bg-tertiary-fixed-dim text-on-tertiary-fixed font-label-md px-xl py-md rounded-xl transition-all duration-300 shadow-xl shadow-tertiary-fixed/20 flex items-center gap-sm transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">explore</span>
                    Jelajahi WebGIS
                </a>
                <a href="{{ route('profil') }}" class="bg-surface-container-lowest/10 hover:bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md px-xl py-md rounded-xl transition-all duration-300 flex items-center gap-sm transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">info</span>
                    Profil Desa
                </a>
            </div>
        </div>
    </section>

    <!-- Profil Singkat Section -->
    <section class="py-24 bg-background relative overflow-hidden">
        <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2xl items-center">
                <div class="space-y-lg relative">
                    <div class="absolute -left-10 -top-10 text-[120px] text-primary/5 font-display-lg font-bold leading-none select-none">SEJARAH</div>
                    <h2 class="font-display-md text-4xl md:text-5xl text-on-background font-bold leading-tight">Menjaga Tradisi,<br><span class="text-secondary">Membangun Masa Depan</span></h2>
                    <p class="font-body-md text-on-surface-variant leading-relaxed text-lg text-justify">
                        Desa Tulusbesar merupakan desa yang menjunjung tinggi nilai-nilai budaya agraris Javanese. 
                        Masyarakat hidup berdampingan dengan alam, menciptakan lingkungan yang asri dan sejahtera. 
                        Melalui inovasi teknologi, kami berupaya mendigitalkan potensi desa untuk kemajuan bersama tanpa melupakan akar tradisi leluhur.
                    </p>
                    <div class="grid grid-cols-2 gap-md pt-md">
                        <div class="bg-surface-container-low p-lg rounded-2xl border border-surface-dim shadow-sm">
                            <div class="text-tertiary-container font-display-md text-3xl font-bold mb-xs">1,240</div>
                            <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Penduduk</div>
                        </div>
                        <div class="bg-surface-container-low p-lg rounded-2xl border border-surface-dim shadow-sm">
                            <div class="text-secondary-container font-display-md text-3xl font-bold mb-xs">340</div>
                            <div class="font-label-sm text-on-surface-variant uppercase tracking-wider">Hektar Area</div>
                        </div>
                    </div>
                </div>
                <div class="relative group">
                    <div class="absolute inset-0 bg-secondary/10 rounded-[2rem] transform rotate-3 scale-105 transition-transform duration-500 group-hover:rotate-6"></div>
                    <img src="https://images.unsplash.com/photo-1582572714421-4824888806fb?q=80&w=1000&auto=format&fit=crop" alt="Pemandangan Desa" class="relative rounded-[2rem] shadow-2xl w-full h-[500px] object-cover border border-outline-variant/30 transform transition-transform duration-500 group-hover:-translate-y-2">
                </div>
            </div>
        </div>
    </section>

    <!-- WebGIS Preview Section -->
    <section class="py-24 bg-surface-container-low relative">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="text-center max-w-[48rem] mx-auto mb-xl space-y-md">
                <h2 class="font-display-md text-4xl font-bold text-on-background">Peta Cerdas <span class="text-tertiary">Tulusbesar</span></h2>
                <p class="font-body-md text-on-surface-variant text-lg">
                    Sistem Informasi Geografis interaktif yang memetakan potensi wisata, UMKM, fasilitas umum, hingga infrastruktur desa secara akurat dan real-time.
                </p>
            </div>
            
            <div class="relative bg-surface-container-lowest rounded-3xl p-sm shadow-[0_20px_50px_rgba(74,43,29,0.1)] border border-outline-variant/30 overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-t from-background/90 via-background/20 to-transparent z-10 flex flex-col justify-end p-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    <a href="#" class="self-center bg-primary text-on-primary font-label-md px-xl py-md rounded-xl transition-all duration-300 hover:scale-105 shadow-xl shadow-primary/30 flex items-center gap-sm">
                        Buka WebGIS Penuh
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1500&auto=format&fit=crop" alt="WebGIS Preview" class="w-full h-[400px] md:h-[600px] object-cover rounded-[1.25rem] filter contrast-110 sepia-[0.2]">
                
                <!-- Dummy UI Overlays to look like a map -->
                <div class="absolute top-lg left-lg bg-surface-container-lowest/90 backdrop-blur-md p-md rounded-xl shadow-lg border border-outline-variant/30 hidden md:block">
                    <div class="font-label-md font-bold mb-sm text-on-surface">Kategori Tersedia</div>
                    <div class="space-y-xs">
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-primary-container"></span> Fasilitas Umum</div>
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-tertiary-container"></span> Situs Budaya</div>
                        <div class="flex items-center gap-sm font-body-sm"><span class="w-3 h-3 rounded-full bg-secondary-container"></span> UMKM Desa</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Highlight Berita Section -->
    <section class="py-24 bg-background">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-xl">
                <div class="max-w-[42rem] space-y-sm">
                    <h2 class="font-display-md text-4xl font-bold text-on-background">Kabar <span class="text-secondary">Desa</span></h2>
                    <p class="font-body-md text-on-surface-variant text-lg">Ikuti perkembangan terbaru, pengumuman, dan publikasi kegiatan kemasyarakatan Desa Tulusbesar.</p>
                </div>
                <a href="#" class="font-label-md text-secondary hover:text-secondary-fixed-dim transition-colors flex items-center gap-xs">
                    Lihat Semua Berita <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                </a>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                <!-- News Card 1 -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1596422846543-74c6eb0809ab?q=80&w=800&auto=format&fit=crop" alt="Berita 1" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-lg">
                        <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 12 Ags 2026
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">Sosialisasi Pengelolaan Sampah Mandiri di RT 04</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3">Warga dihimbau untuk mulai memisahkan sampah organik dan anorganik sebagai langkah awal menuju desa mandiri energi.</p>
                    </div>
                </div>
                
                <!-- News Card 2 -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="h-56 overflow-hidden relative">
                        <div class="absolute top-sm right-sm z-10 bg-tertiary-fixed text-on-tertiary-fixed font-label-sm px-2 py-1 rounded-md shadow-md">Populer</div>
                        <img src="https://images.unsplash.com/photo-1604928141064-207cea6f5722?q=80&w=800&auto=format&fit=crop" alt="Berita 2" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-lg">
                        <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 10 Ags 2026
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">Peresmian Sistem Informasi Geografis (WebGIS)</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3">Mahasiswa KKN bersama aparatur desa resmi meluncurkan platform pemetaan cerdas yang bisa diakses seluruh masyarakat.</p>
                    </div>
                </div>
                
                <!-- News Card 3 -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group">
                    <div class="h-56 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1542621334-a2542d773e0b?q=80&w=800&auto=format&fit=crop" alt="Berita 3" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-lg">
                        <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 08 Ags 2026
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">Kunjungan Wisata ke Candi Sumberawan Meningkat</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3">Sejak diterapkannya sistem katalog wisata digital, antusiasme pengunjung dari luar daerah semakin terlihat.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Include Footer here to appear at bottom of scrollable area -->
    <x-footer />
</div>
@endsection
