@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto">
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 w-full h-full">
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ asset('images/hero-bg.jpg') }}');"></div>
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
                <a href="{{ '#profil' }}" class="bg-surface-container-lowest/10 hover:bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md px-xl py-md rounded-xl transition-all duration-300 flex items-center gap-sm transform hover:-translate-y-1">
                    <span class="material-symbols-outlined">info</span>
                    Profil Desa
                </a>
            </div>
        </div>
    </section>

    <!-- 1. Hero & Kondisi Geografis -->
    <section id="profil" class="relative py-16 md:py-24 bg-surface-container-low overflow-hidden">
        <!-- Hero Background Image (Dummy) -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Pemandangan Desa" class="w-full h-full object-cover opacity-20 filter contrast-125">
            <div class="absolute inset-0 bg-gradient-to-b from-surface-container-low/50 via-surface-container-low/80 to-surface-container-low"></div>
        </div>
        
        <!-- Abstract Javanese Pattern Background -->
        <div class="absolute inset-0 opacity-5 pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%234a2b1d\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
            <div class="text-center max-w-[48rem] mx-auto mb-16 space-y-md">
                <span class="font-label-md text-secondary tracking-widest uppercase">Mengenal Lebih Dekat</span>
                <h1 class="font-display-lg text-5xl md:text-6xl font-bold text-on-background">Profil & Sejarah<br><span class="text-primary">Desa Tulusbesar</span></h1>
                <p class="font-body-md text-on-surface-variant text-lg leading-relaxed">
                    Terletak di Kecamatan Tumpang, Kabupaten Malang, tak jauh dari lereng barat Gunung Bromo, Semeru, dan Tengger. Menawarkan perpaduan kesejukan alam perbukitan dan kesuburan tanah agraris.
                </p>
            </div>

            <!-- Geografis Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
                <!-- Card 1 -->
                <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 rounded-xl bg-primary-container text-on-primary flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">landscape</span>
                    </div>
                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Topografi</h3>
                    <p class="font-body-sm text-on-surface-variant">Berada di ketinggian 550-700 mdpl dengan kontur perbukitan dan dataran yang sejuk.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 rounded-xl bg-tertiary-container text-on-tertiary-container flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">map</span>
                    </div>
                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Luas Wilayah</h3>
                    <p class="font-body-sm text-on-surface-variant">Total luas {{ number_format($profile->area_size ?? 4439, 0, ',', '.') }} Km². Berbatasan dengan Tumpang, Belung, Duwet Dampul, dan Benjor.</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">eco</span>
                    </div>
                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Kondisi Tanah</h3>
                    <p class="font-body-sm text-on-surface-variant">Tanah hitam subur. Sangat cocok untuk padi (hingga 7,5 ton/ha), palawija, dan perkebunan tebu.</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                    <div class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined">cloud</span>
                    </div>
                    <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Iklim</h3>
                    <p class="font-body-sm text-on-surface-variant">Kawasan beriklim sejuk khas pegunungan, mendukung produktivitas pertanian sepanjang tahun.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. Sejarah Desa (Interactive Vertical Timeline) -->
    @php
    $histories = [
        (object)[
            'year' => '1614',
            'title' => 'Era Kadipaten Malang',
            'description' => 'Dipimpin oleh Adipati Ronggo Tohjiwo, berpusat di Kuta Bedah, Buring.'
        ],
        (object)[
            'year' => '1614-1628',
            'title' => 'Pertahanan Tumenggung Alap-alap',
            'description' => 'Membangun pertahanan tangguh hingga memaksa Sultan Agung (Mataram) turun tangan langsung.'
        ],
        (object)[
            'year' => '1638-1643',
            'title' => 'Eksodus ke Tengger',
            'description' => 'Pasca gugurnya Senopati Jolosutro, para pengikut setianya mengamankan pusaka ke wilayah Tengger.'
        ],
        (object)[
            'year' => '1743',
            'title' => 'Penguasaan VOC',
            'description' => 'Berdasarkan Perjanjian Mataram & VOC, wilayah Malang Timur (termasuk Tumpang) mulai diawasi VOC.'
        ],
        (object)[
            'year' => '1830',
            'title' => 'Berdirinya Desa Tulusbesar',
            'description' => 'Senopati Mangun Yudho secara resmi menetapkan area ini sebagai Desa Tulusbesar.'
        ]
    ];
    @endphp
    <section class="py-16 md:py-24 bg-background relative" x-data="{ activeStep: 1 }">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="text-center mb-16">
                <h2 class="font-display-md text-4xl font-bold text-on-background mb-sm">Jejak Sejarah <span class="text-secondary">Babat Malang</span></h2>
                <p class="font-body-md text-on-surface-variant max-w-[42rem] mx-auto">Kisah heroik pelarian Senopati Mataram hingga terbentuknya Desa Tulusbesar pada era penjajahan Belanda.</p>
            </div>

            <div class="flex flex-col lg:flex-row gap-xl relative">
                <!-- Timeline Navigation (Left) -->
                <div class="lg:w-1/3 relative">
                    <div class="sticky top-32 space-y-md relative before:absolute before:inset-y-0 before:left-[19px] before:w-[2px] before:bg-outline-variant/40">
                        
                        @foreach($histories as $index => $history)
                        <button @click="activeStep = {{ $index + 1 }}" class="w-full text-left flex items-start gap-md relative z-10 group focus:outline-none">
                            <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center transition-colors duration-300 border-2"
                                 :class="activeStep === {{ $index + 1 }} ? 'bg-primary border-primary text-on-primary shadow-lg shadow-primary/30' : 'bg-surface-container-lowest border-outline-variant text-on-surface-variant group-hover:border-primary'">
                                <span class="material-symbols-outlined text-[20px]">history_edu</span>
                            </div>
                            <div class="pt-2">
                                <h4 class="font-label-md font-bold transition-colors" :class="activeStep === {{ $index + 1 }} ? 'text-primary' : 'text-on-surface-variant'">{{ $history->year }}</h4>
                                <p class="font-body-sm text-on-surface-variant mt-1" x-show="activeStep === {{ $index + 1 }}" x-collapse>{{ $history->title }}</p>
                            </div>
                        </button>
                        @endforeach
                        
                    </div>
                </div>

                <!-- Timeline Content (Right) -->
                <div class="lg:w-2/3 bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-xl shadow-primary/5 min-h-[400px] flex items-center relative overflow-hidden">
                    <!-- Decorative Background element -->
                    <span class="material-symbols-outlined absolute -bottom-10 -right-10 text-[200px] text-surface-container-high opacity-50 pointer-events-none" style="font-variation-settings: 'FILL' 1;">history_edu</span>

                    <div class="relative z-10">                        
                        @foreach($histories as $index => $history)
                        <!-- Content {{ $index + 1 }} -->
                        <div x-show="activeStep === {{ $index + 1 }}" x-transition.opacity.duration.500ms class="space-y-md" {!! $index > 0 ? 'style="display: none;"' : '' !!}>
                            <div class="inline-block px-sm py-1 bg-primary text-on-primary font-label-sm rounded mb-sm">Tahun {{ $history->year }}</div>
                            <h3 class="font-display-md text-3xl font-bold text-on-surface">{{ $history->title }}</h3>
                            <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                                {{ $history->description }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('sejarah') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-full bg-surface-container border border-outline-variant/50 text-on-surface font-label-md font-bold hover:bg-primary hover:text-on-primary hover:border-primary transition-all shadow-sm hover:shadow-md hover:-translate-y-1">
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                    Baca Sejarah Lengkap Desa Tulusbesar
                </a>
            </div>

        </div>
    </section>

    <!-- 3. Demografi & Ekonomi (Infographic Grid) -->
    <section class="py-16 md:py-24 bg-surface-container-low relative">
        <div class="max-w-screen-xl mx-auto px-container-margin">
            <div class="text-center mb-16">
                <h2 class="font-display-md text-4xl font-bold text-on-background mb-sm">Demografi & <span class="text-primary">Ekonomi</span></h2>
                <p class="font-body-md text-on-surface-variant max-w-[42rem] mx-auto">Gambaran kependudukan dan denyut nadi perekonomian masyarakat Desa Tulusbesar.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
                <!-- Kependudukan Card -->
                <div class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm flex flex-col items-center text-center">
                    <div class="w-16 h-16 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mb-md">
                        <span class="material-symbols-outlined text-[32px]">group</span>
                    </div>
                    <h3 class="font-headline-md text-2xl font-bold text-on-surface mb-xs">Kependudukan</h3>
                    <div class="font-display-lg text-4xl font-bold text-primary mb-md">{{ number_format($profile->total_population ?? 6543, 0, ',', '.') }} <span class="text-lg text-on-surface-variant font-body-md font-normal">Jiwa</span></div>
                    
                    <div class="w-full flex justify-between items-center text-sm font-label-sm mb-2 mt-4">
                        <span class="text-on-surface-variant flex items-center gap-1"><span class="w-3 h-3 rounded-full bg-blue-500"></span> Laki-laki (3.039)</span>
                        <span class="text-on-surface-variant flex items-center gap-1">Perempuan (2.872) <span class="w-3 h-3 rounded-full bg-pink-500"></span></span>
                    </div>
                    <div class="w-full h-3 bg-surface-variant rounded-full overflow-hidden flex">
                        <div class="h-full bg-blue-500" style="width: 51%"></div>
                        <div class="h-full bg-pink-500" style="width: 49%"></div>
                    </div>
                    <p class="font-body-sm text-on-surface-variant mt-4">Tergabung dalam 1.983 Kepala Keluarga (KK).</p>
                </div>

                <!-- Pendidikan Card -->
                <div class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm">
                    <div class="flex items-center gap-md mb-lg">
                        <div class="w-12 h-12 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">school</span>
                        </div>
                        <h3 class="font-headline-md text-2xl font-bold text-on-surface">Pendidikan</h3>
                    </div>
                    
                    <div class="space-y-md">
                        <div>
                            <div class="flex justify-between font-label-sm mb-1 text-on-surface-variant">
                                <span>Tamat SD</span>
                                <span>45,58%</span>
                            </div>
                            <div class="w-full h-2 bg-surface-variant rounded-full overflow-hidden">
                                <div class="h-full bg-tertiary rounded-full" style="width: 45.58%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="flex justify-between font-label-sm mb-1 text-on-surface-variant">
                                <span>Tamat SMP</span>
                                <span>23,98%</span>
                            </div>
                            <div class="w-full h-2 bg-surface-variant rounded-full overflow-hidden">
                                <div class="h-full bg-tertiary/70 rounded-full" style="width: 23.98%"></div>
                            </div>
                        </div>
                    </div>
                    <p class="font-body-sm text-on-surface-variant mt-lg text-justify">
                        Mayoritas penduduk menamatkan pendidikan dasar dan menengah. Program pemberdayaan terus digalakkan untuk meningkatkan kualitas SDM.
                    </p>
                </div>

                <!-- Agama & Budaya Card -->
                <div class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm">
                    <div class="flex items-center gap-md mb-md">
                        <div class="w-12 h-12 rounded-full bg-primary/10 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined text-[24px]">mosque</span>
                        </div>
                        <h3 class="font-headline-md text-2xl font-bold text-on-surface">Agama & Budaya</h3>
                    </div>
                    <p class="font-body-md text-on-surface-variant mb-md text-justify">
                        Mayoritas Islam (6.100 jiwa). Suasana budaya Jawa sangat kental dengan akulturasi tradisi lokal yang kuat.
                    </p>
                    <div class="flex flex-wrap gap-sm">
                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Nyadran</span>
                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Slametan</span>
                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Suroan</span>
                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Tahlilan</span>
                        <span class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Mithoni</span>
                    </div>
                </div>

                <!-- Ekonomi & UMKM Card (Spans 2 columns on lg) -->
                <div class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm lg:col-span-3">
                    <div class="flex flex-col md:flex-row items-center gap-xl">
                        <div class="w-full md:w-1/3 flex justify-center">
                            <!-- Pure CSS Pie Chart representation -->
                            <div class="relative w-48 h-48 rounded-full flex items-center justify-center text-center shadow-inner border-8 border-surface-variant" style="background: conic-gradient(#4a2b1d 0% 45%, #fd934c 45% 70%, #cba72f 70% 100%);">
                                <div class="absolute inset-2 bg-surface-container-lowest rounded-full flex flex-col items-center justify-center shadow-lg">
                                    <span class="font-display-md text-3xl font-bold text-primary">45%</span>
                                    <span class="font-label-sm text-on-surface-variant">Pertanian</span>
                                </div>
                            </div>
                        </div>
                        <div class="w-full md:w-2/3 space-y-md">
                            <h3 class="font-headline-md text-3xl font-bold text-on-surface">Ekonomi & UMKM Desa</h3>
                            <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                                Sektor pertanian dan perkebunan menjadi pilar utama, menyumbang <strong>45%</strong> dari Produk Domestik Desa Bruto. Desa Tulusbesar juga sangat membanggakan sektor UMKM-nya.
                            </p>
                            <div class="bg-primary/5 border border-primary/20 p-md rounded-xl flex gap-md items-start mt-4">
                                <span class="material-symbols-outlined text-primary text-[32px]">storefront</span>
                                <div>
                                    <h4 class="font-label-md font-bold text-primary mb-1">Sentra Produksi Tahu</h4>
                                    <p class="font-body-sm text-on-surface-variant">Memiliki <i>home industry</i> maju yang mendominasi suplai pasar Tumpang hingga Wates Poncokusumo. Sektor jasa dan perdagangan juga terus menunjukkan grafik yang positif.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. Pemerintahan (Simple List / Table) -->
    <section class="py-16 md:py-24 bg-background relative overflow-hidden">
        <!-- Abstract Pattern -->
        <div class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-surface-container-low to-transparent opacity-50 pointer-events-none"></div>

        <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
            <div class="flex flex-col lg:flex-row gap-2xl items-center">
                <div class="lg:w-1/2 space-y-md">
                    <span class="font-label-md text-secondary tracking-widest uppercase">Struktur Tata Kelola</span>
                    <h2 class="font-display-md text-4xl font-bold text-on-background">Pemerintahan <br>Administratif</h2>
                    <p class="font-body-md text-on-surface-variant text-lg leading-relaxed mb-6">
                        Pemerintahan Desa Tulusbesar dikelola oleh jajaran perangkat desa yang berdedikasi. Secara administratif wilayah ini dibagi untuk mengoptimalkan pelayanan kepada masyarakat.
                    </p>
                    
                    <div class="flex flex-wrap gap-4">
                        @if(isset($officials) && $officials->count() > 0)
                            @foreach($officials as $official)
                            <div class="group relative flex items-center gap-4 bg-white/80 dark:bg-surface-container-lowest/80 backdrop-blur-md p-4 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-max overflow-hidden cursor-default">
                                <div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                @if($official->image_path)
                                    <img src="{{ asset('storage/' . $official->image_path) }}" alt="{{ $official->name }}" class="w-16 h-16 rounded-full object-cover border-2 border-primary/20 shadow-sm relative z-10">
                                @else
                                    <!-- Smart Avatar using initials -->
                                    <div class="w-16 h-16 rounded-full bg-primary-container text-primary font-bold flex items-center justify-center text-xl border-2 border-primary/20 shadow-sm relative z-10">
                                        {{ collect(explode(' ', $official->name))->take(2)->map(fn($n) => substr($n, 0, 1))->join('') }}
                                    </div>
                                @endif
                                <div class="relative z-10">
                                    <div class="font-label-md font-bold text-[#3e2723] uppercase tracking-tight">{{ $official->name }}</div>
                                    <div class="font-body-sm text-primary font-semibold mt-0.5">{{ $official->position }}</div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="group relative flex items-center gap-4 bg-white/80 dark:bg-surface-container-lowest/80 backdrop-blur-md p-4 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-max overflow-hidden cursor-default">
                                <div class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                                <img src="{{ asset('images/dummy/kades.jpg') }}" alt="Kepala Desa" class="w-16 h-16 rounded-full object-cover border-2 border-primary/20 shadow-sm relative z-10">
                                <div class="relative z-10">
                                    <div class="font-label-md font-bold text-[#3e2723] uppercase tracking-tight">Hudi Mariono</div>
                                    <div class="font-body-sm text-primary font-semibold mt-0.5">Kepala Desa Tulusbesar</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="lg:w-1/2 w-full">
                    <div class="bg-white/90 dark:bg-surface-container-lowest/90 backdrop-blur-xl rounded-3xl border border-outline-variant/50 shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-500">
                        <div class="bg-gradient-to-br from-[#8c5a35] to-[#593922] text-white p-6 flex items-center justify-between shadow-inner">
                            <h3 class="font-headline-md text-xl font-bold tracking-wide">Wilayah Dusun</h3>
                            <span class="bg-white/20 text-white backdrop-blur-sm px-4 py-1.5 rounded-full font-label-sm font-bold border border-white/30 shadow-sm">4 Wilayah, 7 RW</span>
                        </div>
                        <ul class="divide-y divide-outline-variant/20 p-2">
                            <li class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner"><span class="material-symbols-outlined text-[24px]">pin_drop</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Krajan</h4>
                                    <p class="font-body-sm text-on-surface-variant">Pusat Administratif Desa</p>
                                </div>
                            </li>
                            <li class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner"><span class="material-symbols-outlined text-[24px]">account_balance</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Kemulan</h4>
                                    <p class="font-body-sm text-on-surface-variant">Situs Makam Bersejarah</p>
                                </div>
                            </li>
                            <li class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner"><span class="material-symbols-outlined text-[24px]">maps_home_work</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Prapatan Tulusayu</h4>
                                    <p class="font-body-sm text-on-surface-variant">Pemukiman Padat Penduduk</p>
                                </div>
                            </li>
                            <li class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner"><span class="material-symbols-outlined text-[24px]">agriculture</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Sumbersari</h4>
                                    <p class="font-body-sm text-on-surface-variant">Area Pertanian & Sumber Air</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    

    <!-- Peta Cerdas / WebGIS Preview Section -->
    <section class="py-16 md:py-24 bg-surface-container-low border-y border-outline-variant/20">
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                
                <!-- Left: Maps Embed -->
                <div class="w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-xl border border-outline-variant/30">
                    <iframe 
                        src="https://maps.google.com/maps?q=Desa%20Tulusbesar,%20Kec.%20Tumpang,%20Kabupaten%20Malang&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                <!-- Right: Village Info & Buttons -->
                <div class="space-y-8">
                    <div>
                        <h2 class="font-display-lg text-4xl md:text-5xl font-bold text-on-background mb-6 uppercase tracking-tight">
                            Desa Tulusbesar
                        </h2>
                        
                        <div class="space-y-4">
                            <div class="flex items-start gap-4 text-on-surface-variant font-body-md">
                                <span class="material-symbols-outlined mt-1 text-on-surface">location_on</span>
                                <span>Kantor Desa Tulusbesar, Kec. Tumpang, Kabupaten Malang, Jawa Timur</span>
                            </div>
                            <div class="flex items-center gap-4 text-on-surface-variant font-body-md">
                                <span class="material-symbols-outlined text-on-surface">call</span>
                                <span>(0341) -</span>
                            </div>
                            <div class="flex items-center gap-4 text-on-surface-variant font-body-md">
                                <span class="material-symbols-outlined text-on-surface">mail</span>
                                <span>pemdes.tulusbesar@gmail.com</span>
                            </div>
                            <div class="flex items-center gap-4 text-on-surface-variant font-body-md">
                                <span class="material-symbols-outlined text-on-surface">language</span>
                                <span>tulusbesar.desa.id</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-outline-variant/30">
                        <div class="mb-6">
                            <h3 class="font-headline-sm font-bold text-on-surface mb-3">Follow Us:</h3>
                            <div class="flex gap-2">
                                <a href="#" class="w-10 h-10 rounded-full bg-[#CD201F] text-white flex items-center justify-center hover:opacity-90 transition-opacity shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M19.812 5.418c.861.23 1.538.907 1.768 1.768C21.998 8.746 22 12 22 12s0 3.255-.418 4.814a2.504 2.504 0 0 1-1.768 1.768c-1.56.419-7.814.419-7.814.419s-6.255 0-7.814-.419a2.505 2.505 0 0 1-1.768-1.768C2 15.255 2 12 2 12s0-3.255.417-4.814a2.507 2.507 0 0 1 1.768-1.768C5.744 5 11.998 5 11.998 5s6.255 0 7.814.418ZM15.194 12 10 15V9l5.194 3Z" clip-rule="evenodd"></path></svg>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-[#1877F2] text-white flex items-center justify-center hover:opacity-90 transition-opacity shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path></svg>
                                </a>
                                <a href="#" class="w-10 h-10 rounded-full bg-gradient-to-tr from-[#f09433] via-[#e6683c] to-[#bc1888] text-white flex items-center justify-center hover:opacity-90 transition-opacity shadow-sm">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path></svg>
                                </a>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- Button WebGIS -->
                            <a href="{{ route('peta') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-on-primary font-label-md font-bold hover:bg-primary/90 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                <span class="material-symbols-outlined text-[20px]">explore</span>
                                Buka Peta WebGIS
                            </a>
                            <!-- Button Maps -->
                            <a href="https://www.google.com/maps/place/Tulusbesar,+Kec.+Tumpang,+Kabupaten+Malang,+Jawa+Timur/" target="_blank" rel="noopener noreferrer" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-surface-container border border-outline-variant/50 text-on-surface font-label-md font-bold hover:bg-surface-variant transition-all hover:border-outline">
                                <span class="material-symbols-outlined text-[20px]">map</span>
                                Kunjungi Desa Tulusbesar
                            </a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- Highlight Berita Section -->
    <section class="py-16 md:py-24 bg-background">
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
                @foreach($news as $index => $berita)
                <!-- News Card -->
                <div class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col">
                    <div class="h-56 overflow-hidden relative">
                        @if($index === 0)
                        <div class="absolute top-sm right-sm z-10 bg-tertiary-fixed text-on-tertiary-fixed font-label-sm px-2 py-1 rounded-md shadow-md">Terbaru</div>
                        @endif
                        <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : asset('storage/' . $berita->image_path)) }}" alt="{{ $berita->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="p-lg flex-grow flex flex-col">
                        <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                            <span class="material-symbols-outlined text-[16px]">calendar_today</span> 
                            <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d M Y') }}</time>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">{{ $berita->title }}</h3>
                        <p class="font-body-sm text-on-surface-variant line-clamp-3 text-justify mb-4">{!! strip_tags($berita->content) !!}</p>
                        <a href="{{ route('berita.show', $berita->slug) }}" class="w-full bg-surface-container hover:bg-primary text-primary hover:text-on-primary font-label-sm py-2 rounded-xl transition-colors border border-outline-variant/50 hover:border-primary flex items-center justify-center gap-2 mt-auto">
                            Selengkapnya <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Include Footer here to appear at bottom of scrollable area -->
    <x-footer />
</div>
@endsection
