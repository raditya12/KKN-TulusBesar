@extends('layouts.app')

@section('content')
<div class="w-full overflow-y-auto custom-scrollbar">
    <!-- 1. Hero & Kondisi Geografis -->
    <section class="relative pt-24 md:pt-32 pb-16 md:pb-24 bg-surface-container-low overflow-hidden">
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
            
            <!-- Historic Dummy Image Gallery -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6">
                <img src="https://images.unsplash.com/photo-1533613220915-609f661a6fe1?q=80&w=600&auto=format&fit=crop" alt="Sejarah 1" class="w-full h-48 object-cover rounded-2xl shadow-md sepia-[0.4]">
                <img src="https://images.unsplash.com/photo-1582572714421-4824888806fb?q=80&w=600&auto=format&fit=crop" alt="Sejarah 2" class="w-full h-48 object-cover rounded-2xl shadow-md sepia-[0.4]">
                <img src="https://images.unsplash.com/photo-1629851608678-cbfcc9689fcc?q=80&w=600&auto=format&fit=crop" alt="Sejarah 3" class="w-full h-48 object-cover rounded-2xl shadow-md sepia-[0.4]">
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
                        Saat ini, pemerintahan Desa Tulusbesar dipimpin oleh <strong>Bapak Hudi Mariono</strong> selaku Kepala Desa. Secara administratif wilayah ini dibagi untuk mengoptimalkan pelayanan kepada masyarakat.
                    </p>
                    <div class="flex items-center gap-4 bg-surface-container-lowest p-4 rounded-2xl border border-outline-variant/30 shadow-sm w-max">
                        <img src="{{ asset('images/dummy/kades.jpg') }}" alt="Kepala Desa" class="w-16 h-16 rounded-full object-cover">
                        <div>
                            <div class="font-label-md font-bold text-on-surface">Hudi Mariono</div>
                            <div class="font-body-sm text-on-surface-variant">Kepala Desa Tulusbesar</div>
                        </div>
                    </div>
                </div>
                
                <div class="lg:w-1/2 w-full">
                    <div class="bg-surface-container-lowest rounded-3xl border border-outline-variant/30 shadow-lg overflow-hidden">
                        <div class="bg-primary-container text-on-primary-container p-lg flex items-center justify-between">
                            <h3 class="font-headline-md text-xl font-bold">Wilayah Dusun</h3>
                            <span class="bg-on-primary-container text-primary-container px-3 py-1 rounded-full font-label-sm font-bold">4 Wilayah, 7 RW</span>
                        </div>
                        <ul class="divide-y divide-outline-variant/20">
                            <li class="p-md hover:bg-surface-container/50 transition-colors flex items-center gap-md">
                                <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant"><span class="material-symbols-outlined text-[20px]">holiday_village</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-on-surface">Dusun Krajan</h4>
                                    <p class="font-body-sm text-on-surface-variant">Pusat Administratif Desa</p>
                                </div>
                            </li>
                            <li class="p-md hover:bg-surface-container/50 transition-colors flex items-center gap-md">
                                <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant"><span class="material-symbols-outlined text-[20px]">holiday_village</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-on-surface">Dusun Kemulan</h4>
                                    <p class="font-body-sm text-on-surface-variant">Situs Makam Bersejarah</p>
                                </div>
                            </li>
                            <li class="p-md hover:bg-surface-container/50 transition-colors flex items-center gap-md">
                                <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant"><span class="material-symbols-outlined text-[20px]">holiday_village</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-on-surface">Dusun Prapatan Tulusayu</h4>
                                    <p class="font-body-sm text-on-surface-variant">Pemukiman Padat Penduduk</p>
                                </div>
                            </li>
                            <li class="p-md hover:bg-surface-container/50 transition-colors flex items-center gap-md">
                                <div class="w-10 h-10 rounded-full bg-surface-variant flex items-center justify-center text-on-surface-variant"><span class="material-symbols-outlined text-[20px]">holiday_village</span></div>
                                <div>
                                    <h4 class="font-label-md font-bold text-on-surface">Dusun Sumbersari</h4>
                                    <p class="font-body-sm text-on-surface-variant">Area Pertanian & Sumber Air</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />
</div>
@endsection
