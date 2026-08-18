@extends('layouts.app')

@section('content')
    <div class="w-full overflow-y-auto">
        <!-- Hero Section -->
        <section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 w-full h-full">
                <div class="absolute inset-0 bg-cover bg-center"
                    style="background-image: url('{{ asset('images/hero-bg.jpg') }}');"></div>
                <div class="absolute inset-0 bg-primary/70 mix-blend-multiply"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent"></div>
            </div>

            <!-- Hero Content -->
            <div
                class="relative z-10 text-center px-container-margin max-w-[56rem] mx-auto flex flex-col items-center gap-lg">
                <span
                    class="px-md py-xs rounded-full bg-surface-container-lowest/20 backdrop-blur-md border border-surface-container-lowest/30 text-on-primary font-label-md tracking-wider uppercase text-sm shadow-xl shadow-primary/20">
                    Selamat Datang di
                </span>
                <h1
                    class="font-display-lg text-[clamp(40px,8vw,80px)] leading-tight text-on-primary font-bold drop-shadow-lg">
                    Desa Tulusbesar
                </h1>
                <p class="font-body-lg text-lg md:text-xl text-on-primary/90 max-w-[42rem] drop-shadow-md">
                    Harmoni kearifan lokal dan inovasi tata kelola cerdas dalam satu genggaman. Jelajahi keindahan budaya
                    dan infrastruktur desa kami.
                </p>


            </div>
        </section>

        <!-- Repositori Dokumen (Layanan Publik Utama) -->
        <section id="dokumen" class="py-16 md:py-24 bg-background relative z-20">
            <div class="max-w-screen-xl mx-auto px-container-margin">
                <div class="text-center mb-12 space-y-3">
                    <span class="font-label-md text-secondary tracking-widest uppercase">Layanan Mandiri Publik</span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-bold text-on-background">Pelayanan Administrasi
                        <span class="text-primary">Desa Tulusbesar</span></h2>
                    <p class="font-body-md text-on-surface-variant max-w-[48rem] mx-auto text-lg">
                        Cari, baca persyaratan, dan unduh formulir dokumen pelayanan administrasi kependudukan Anda langsung
                        dari rumah.
                    </p>
                </div>

                <div
                    class="bg-surface-container-lowest rounded-3xl shadow-xl shadow-primary/5 border border-outline-variant/30 overflow-hidden">
                    @livewire('document-repository')
                </div>
            </div>
        </section>

        <!-- 1. Hero & Kondisi Geografis -->
        <section id="profil" class="relative py-16 md:py-24 bg-surface-container-low overflow-hidden">
            <!-- Hero Background Image (Dummy) -->
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Pemandangan Desa"
                    class="w-full h-full object-cover opacity-20 filter contrast-125">
                <div
                    class="absolute inset-0 bg-gradient-to-b from-surface-container-low/50 via-surface-container-low/80 to-surface-container-low">
                </div>
            </div>

            <!-- Abstract Javanese Pattern Background -->
            <div class="absolute inset-0 opacity-5 pointer-events-none"
                style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%234a2b1d\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
            </div>

            <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
                <div class="text-center max-w-[48rem] mx-auto mb-16 space-y-md">
                    <span class="font-label-md text-secondary tracking-widest uppercase">Mengenal Lebih Dekat</span>
                    <h1 class="font-display-lg text-5xl md:text-6xl font-bold text-on-background">Profil & Sejarah<br><span
                            class="text-primary">Desa Tulusbesar</span></h1>
                    <p class="font-body-md text-on-surface-variant text-lg leading-relaxed">
                        Terletak di Kecamatan Tumpang, Kabupaten Malang, tak jauh dari lereng barat Gunung Bromo, Semeru,
                        dan Tengger. Menawarkan perpaduan kesejukan alam perbukitan dan kesuburan tanah agraris.
                    </p>
                </div>

                <!-- Geografis Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-lg">
                    <!-- Card 1 -->
                    <div
                        class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 rounded-xl bg-primary-container text-on-primary flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">landscape</span>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Topografi</h3>
                        <p class="font-body-sm text-on-surface-variant">Berada di ketinggian 550-700 mdpl dengan kontur
                            perbukitan dan dataran yang sejuk.</p>
                    </div>
                    <!-- Card 2 -->
                    <div
                        class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 rounded-xl bg-tertiary-container text-on-tertiary-container flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">map</span>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Luas Wilayah</h3>
                        <p class="font-body-sm text-on-surface-variant">Total luas
                            {{ number_format($profile->area_size ?? 4439, 0, ',', '.') }} Km². Berbatasan dengan Tumpang,
                            Belung, Duwet Dampul, dan Benjor.</p>
                    </div>
                    <!-- Card 3 -->
                    <div
                        class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 rounded-xl bg-secondary-container text-on-secondary-container flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">eco</span>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Kondisi Tanah</h3>
                        <p class="font-body-sm text-on-surface-variant">Tanah hitam subur. Sangat cocok untuk padi (hingga
                            7,5 ton/ha), palawija, dan perkebunan tebu.</p>
                    </div>
                    <!-- Card 4 -->
                    <div
                        class="bg-surface-container-lowest p-lg rounded-2xl shadow-sm border border-outline-variant/30 hover:shadow-md transition-shadow group">
                        <div
                            class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center mb-md group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined">cloud</span>
                        </div>
                        <h3 class="font-headline-md text-xl font-bold text-on-surface mb-xs">Iklim</h3>
                        <p class="font-body-sm text-on-surface-variant">Kawasan beriklim sejuk khas pegunungan, mendukung
                            produktivitas pertanian sepanjang tahun.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- 2. Sejarah Desa (Interactive Vertical Timeline) -->
        @php
            $histories = [
                (object) [
                    'year' => '1614',
                    'title' => 'Era Kadipaten Malang',
                    'description' => 'Dipimpin oleh Adipati Ronggo Tohjiwo, berpusat di Kuta Bedah, Buring. Wilayah ini dikenal sebagai Malang Kuso (Malang Eng-Kuso) berkat kemakmuran hasil taninya.',
                    'image' => 'images/kadipaten.jpg'
                ],
                (object) [
                    'year' => '1614-1628',
                    'title' => 'Serangan Mataram',
                    'description' => 'Sultan Agung (Mataram) mengutus Patih Surontanu untuk menyerang Kadipaten Malang. Terjadilah peperangan sengit yang memporak-porandakan wilayah tersebut. Tumenggung Alap-alap membangun pertahanan.',
                    'image' => 'images/mataram.jpg'
                ],
                (object) [
                    'year' => '1638-1643',
                    'title' => 'Pelarian & Wafatnya Pahlawan',
                    'description' => 'Senopati Mangun Yudho terdesak dan melarikan diri, lalu dirawat oleh Mbok Rondo Kuning (asal nama Desa <strong>Tulusayu</strong>). Hingga akhirnya beliau moksa di Binangun, dan selimutnya dimakamkan di <strong>Kemulan</strong>.',
                    'image' => 'images/MangunDharma.jpg'
                ],
                (object) [
                    'year' => '1743',
                    'title' => 'Penguasaan VOC',
                    'description' => 'Berdasarkan Perjanjian Mataram & VOC, wilayah Malang Timur diawasi VOC. Pembukaan lahan perkebunan tebu dan kopi dilakukan secara masif.',
                    'image' => 'images/voc.jpg'
                ],
                (object) [
                    'year' => '1830',
                    'title' => 'Berdirinya Desa Tulusbesar',
                    'description' => 'Setelah Perang Jawa, Senopati Mangun Yudho diyakini oleh masyarakat sebagai tokoh yang melakukan <em>babat alas</em> dan menamakan daerah pemukiman baru ini dengan nama <strong>"Tulusbesar"</strong>.',
                    'image' => 'images/balaidesa.png'
                ]
            ];
        @endphp
        <section class="py-16 md:py-24 bg-background relative" x-data="{ activeStep: 1 }">
            <div class="max-w-screen-xl mx-auto px-container-margin">
                <div class="text-center mb-16">
                    <h2 class="font-display-md text-4xl font-bold text-on-background mb-sm">Jejak Sejarah <span
                            class="text-secondary">Babat Malang</span></h2>
                    <p class="font-body-md text-on-surface-variant max-w-[42rem] mx-auto">Kisah heroik pelarian Senopati
                        Mataram hingga terbentuknya Desa Tulusbesar pada era penjajahan Belanda.</p>
                </div>

                <div class="flex flex-col lg:flex-row gap-xl relative">
                    <!-- Timeline Navigation (Left) -->
                    <div class="lg:w-1/3 relative">
                        <div
                            class="sticky top-32 space-y-md relative before:absolute before:inset-y-0 before:left-[19px] before:w-[2px] before:bg-outline-variant/40">

                            @foreach($histories as $index => $history)
                                <button @click="activeStep = {{ $index + 1 }}"
                                    class="w-full text-left flex items-start gap-md relative z-10 group focus:outline-none">
                                    <div class="w-10 h-10 shrink-0 rounded-full flex items-center justify-center transition-colors duration-300 border-2"
                                        :class="activeStep === {{ $index + 1 }} ? 'bg-primary border-primary text-on-primary shadow-lg shadow-primary/30' : 'bg-surface-container-lowest border-outline-variant text-on-surface-variant group-hover:border-primary'">
                                        <span class="material-symbols-outlined text-[20px]">history_edu</span>
                                    </div>
                                    <div class="pt-2">
                                        <h4 class="font-label-md font-bold transition-colors"
                                            :class="activeStep === {{ $index + 1 }} ? 'text-primary' : 'text-on-surface-variant'">
                                            {{ $history->year }}</h4>
                                        <p class="font-body-sm text-on-surface-variant mt-1"
                                            x-show="activeStep === {{ $index + 1 }}" x-collapse>{{ $history->title }}</p>
                                    </div>
                                </button>
                            @endforeach

                        </div>
                    </div>

                    <!-- Timeline Content (Right) -->
                    <div
                        class="lg:w-2/3 bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-xl shadow-primary/5 min-h-[400px] flex items-center relative overflow-hidden">
                        <!-- Decorative Background element -->
                        <span
                            class="material-symbols-outlined absolute -bottom-10 -right-10 text-[200px] text-surface-container-high opacity-50 pointer-events-none"
                            style="font-variation-settings: 'FILL' 1;">history_edu</span>

                        <div class="relative z-10">
                            @foreach($histories as $index => $history)
                                <!-- Content {{ $index + 1 }} -->
                                <div x-show="activeStep === {{ $index + 1 }}" x-transition.opacity.duration.500ms
                                    class="space-y-md" {!! $index > 0 ? 'style="display: none;"' : '' !!}>
                                    @if(isset($history->image))
                                        <div class="rounded-3xl overflow-hidden shadow-lg mb-4 aspect-video">
                                            <img src="{{ asset($history->image) }}" alt="{{ $history->title }}"
                                                class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                    <div class="inline-block px-sm py-1 bg-primary text-on-primary font-label-sm rounded mb-sm">
                                        Tahun {{ $history->year }}</div>
                                    <h3 class="font-display-md text-3xl font-bold text-on-surface">{{ $history->title }}</h3>
                                    <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                                        {!! $history->description !!}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>



            </div>
        </section>

        <!-- 3. Demografi & Ekonomi (Infographic Grid) -->
        <section class="py-16 md:py-24 bg-surface-container-low relative">
            <div class="max-w-screen-xl mx-auto px-container-margin">
                <div class="text-center mb-16">
                    <h2 class="font-display-md text-4xl font-bold text-on-background mb-sm">Demografi & <span
                            class="text-primary">Ekonomi</span></h2>
                    <p class="font-body-md text-on-surface-variant max-w-[42rem] mx-auto">Gambaran kependudukan dan denyut
                        nadi perekonomian masyarakat Desa Tulusbesar.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-lg">
                    <!-- Kependudukan Card -->
                    <div
                        class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm flex flex-col items-center text-center">
                        <div
                            class="w-16 h-16 rounded-full bg-secondary/10 text-secondary flex items-center justify-center mb-md">
                            <span class="material-symbols-outlined text-[32px]">group</span>
                        </div>
                        <h3 class="font-headline-md text-2xl font-bold text-on-surface mb-xs">Kependudukan</h3>
                        <div class="font-display-lg text-4xl font-bold text-primary mb-md">
                            {{ number_format($profile->total_population ?? 6543, 0, ',', '.') }} <span
                                class="text-lg text-on-surface-variant font-body-md font-normal">Jiwa</span></div>

                        <div class="w-full flex justify-between items-center text-sm font-label-sm mb-2 mt-4">
                            <span class="text-on-surface-variant flex items-center gap-1"><span
                                    class="w-3 h-3 rounded-full bg-blue-500"></span> Laki-laki (3.039)</span>
                            <span class="text-on-surface-variant flex items-center gap-1">Perempuan (2.872) <span
                                    class="w-3 h-3 rounded-full bg-pink-500"></span></span>
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
                            <div
                                class="w-12 h-12 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center">
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
                            Mayoritas penduduk menamatkan pendidikan dasar dan menengah. Program pemberdayaan terus
                            digalakkan untuk meningkatkan kualitas SDM.
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
                            Mayoritas Islam (6.100 jiwa). Suasana budaya Jawa sangat kental dengan akulturasi tradisi lokal
                            yang kuat.
                        </p>
                        <div class="flex flex-wrap gap-sm">
                            <span
                                class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Nyadran</span>
                            <span
                                class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Slametan</span>
                            <span
                                class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Suroan</span>
                            <span
                                class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Tahlilan</span>
                            <span
                                class="px-3 py-1 bg-surface-variant text-on-surface-variant font-label-sm rounded-full">Mithoni</span>
                        </div>
                    </div>

                    <!-- Ekonomi & UMKM Card (Spans 2 columns on lg) -->
                    <div
                        class="bg-surface-container-lowest p-xl rounded-3xl border border-outline-variant/30 shadow-sm lg:col-span-3">
                        <div class="flex flex-col md:flex-row items-center gap-xl">
                            <div class="w-full md:w-1/3 flex justify-center">
                                <!-- Pure CSS Pie Chart representation -->
                                <div class="relative w-48 h-48 rounded-full flex items-center justify-center text-center shadow-inner border-8 border-surface-variant"
                                    style="background: conic-gradient(#4a2b1d 0% 45%, #fd934c 45% 70%, #cba72f 70% 100%);">
                                    <div
                                        class="absolute inset-2 bg-surface-container-lowest rounded-full flex flex-col items-center justify-center shadow-lg">
                                        <span class="font-display-md text-3xl font-bold text-primary">45%</span>
                                        <span class="font-label-sm text-on-surface-variant">Pertanian</span>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full md:w-2/3 space-y-md">
                                <h3 class="font-headline-md text-3xl font-bold text-on-surface">Ekonomi & UMKM Desa</h3>
                                <p class="font-body-md text-on-surface-variant text-lg leading-relaxed text-justify">
                                    Sektor pertanian dan perkebunan menjadi pilar utama, menyumbang <strong>45%</strong>
                                    dari Produk Domestik Desa Bruto. Desa Tulusbesar juga sangat membanggakan sektor
                                    UMKM-nya.
                                </p>
                                <div
                                    class="bg-primary/5 border border-primary/20 p-md rounded-xl flex gap-md items-start mt-4">
                                    <span class="material-symbols-outlined text-primary text-[32px]">storefront</span>
                                    <div>
                                        <h4 class="font-label-md font-bold text-primary mb-1">Sentra Produksi Tahu</h4>
                                        <p class="font-body-sm text-on-surface-variant">Memiliki <i>home industry</i> maju
                                            yang mendominasi suplai pasar Tumpang hingga Wates Poncokusumo. Sektor jasa dan
                                            perdagangan juga terus menunjukkan grafik yang positif.</p>
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
            <div
                class="absolute top-0 right-0 w-1/3 h-full bg-gradient-to-l from-surface-container-low to-transparent opacity-50 pointer-events-none">
            </div>

            <div class="max-w-screen-xl mx-auto px-container-margin relative z-10">
                <div class="flex flex-col lg:flex-row gap-2xl items-center">
                    <div class="lg:w-1/2 space-y-md">
                        <span class="font-label-md text-secondary tracking-widest uppercase">Struktur Tata Kelola</span>
                        <h2 class="font-display-md text-4xl font-bold text-on-background">Pemerintahan <br>Administratif
                        </h2>
                        <p class="font-body-md text-on-surface-variant text-lg leading-relaxed mb-6">
                            Pemerintahan Desa Tulusbesar dikelola oleh jajaran perangkat desa yang berdedikasi. Secara
                            administratif wilayah ini dibagi untuk mengoptimalkan pelayanan kepada masyarakat.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            @if(isset($officials) && $officials->count() > 0)
                                @foreach($officials as $official)
                                    <div
                                        class="group relative flex items-center gap-4 bg-white/80 dark:bg-surface-container-lowest/80 backdrop-blur-md p-4 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-full sm:w-max overflow-hidden cursor-default">
                                        <div
                                            class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                        </div>
                                        @if($official->image_path)
                                            <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($official->image_path) }}"
                                                alt="{{ $official->name }}"
                                                class="w-16 h-16 rounded-full object-cover border-2 border-primary/20 shadow-sm relative z-10">
                                        @else
                                            <!-- Smart Avatar using initials -->
                                            <div
                                                class="w-16 h-16 rounded-full bg-primary-container text-primary font-bold flex items-center justify-center text-xl border-2 border-primary/20 shadow-sm relative z-10">
                                                {{ collect(explode(' ', $official->name))->take(2)->map(fn($n) => substr($n, 0, 1))->join('') }}
                                            </div>
                                        @endif
                                        <div class="relative z-10">
                                            <div class="font-label-md font-bold text-[#3e2723] uppercase tracking-tight">
                                                {{ $official->name }}</div>
                                            <div class="font-body-sm text-primary font-semibold mt-0.5">{{ $official->position }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="group relative flex items-center gap-4 bg-white/80 dark:bg-surface-container-lowest/80 backdrop-blur-md p-4 rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 w-max overflow-hidden cursor-default">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                    </div>
                                    <img src="{{ asset('images/dummy/kades.jpg') }}" alt="Kepala Desa"
                                        class="w-16 h-16 rounded-full object-cover border-2 border-primary/20 shadow-sm relative z-10">
                                    <div class="relative z-10">
                                        <div class="font-label-md font-bold text-[#3e2723] uppercase tracking-tight">Hudi
                                            Mariono</div>
                                        <div class="font-body-sm text-primary font-semibold mt-0.5">Kepala Desa Tulusbesar</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="lg:w-1/2 w-full">
                        <div
                            class="bg-white/90 dark:bg-surface-container-lowest/90 backdrop-blur-xl rounded-3xl border border-outline-variant/50 shadow-2xl overflow-hidden transform hover:scale-[1.01] transition-transform duration-500">
                            <div
                                class="bg-gradient-to-br from-[#8c5a35] to-[#593922] text-white p-6 flex items-center justify-between shadow-inner">
                                <h3 class="font-headline-md text-xl font-bold tracking-wide">Wilayah Dusun</h3>
                                <span
                                    class="bg-white/20 text-white backdrop-blur-sm px-4 py-1.5 rounded-full font-label-sm font-bold border border-white/30 shadow-sm">4
                                    Wilayah, 7 RW</span>
                            </div>
                            <ul class="divide-y divide-outline-variant/20 p-2">
                                <li
                                    class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                        <span class="material-symbols-outlined text-[24px]">pin_drop</span></div>
                                    <div>
                                        <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Krajan</h4>
                                        <p class="font-body-sm text-on-surface-variant">Pusat Administratif Desa</p>
                                    </div>
                                </li>
                                <li
                                    class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                        <span class="material-symbols-outlined text-[24px]">account_balance</span></div>
                                    <div>
                                        <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Kemulan</h4>
                                        <p class="font-body-sm text-on-surface-variant">Situs Makam Bersejarah</p>
                                    </div>
                                </li>
                                <li
                                    class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                        <span class="material-symbols-outlined text-[24px]">maps_home_work</span></div>
                                    <div>
                                        <h4 class="font-label-md font-bold text-[#3e2723] text-lg">Dusun Prapatan Tulusayu
                                        </h4>
                                        <p class="font-body-sm text-on-surface-variant">Pemukiman Padat Penduduk</p>
                                    </div>
                                </li>
                                <li
                                    class="p-4 rounded-2xl hover:bg-surface-container/50 hover:shadow-sm transition-all duration-300 flex items-center gap-4 cursor-default">
                                    <div
                                        class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-primary shadow-inner">
                                        <span class="material-symbols-outlined text-[24px]">agriculture</span></div>
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



        <!-- Highlight Berita Section -->
        <section class="py-16 md:py-24 bg-background border-y border-outline-variant/20">
            <div class="max-w-screen-xl mx-auto px-container-margin">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-md mb-xl">
                    <div class="max-w-[42rem] space-y-sm">
                        <h2 class="font-display-md text-4xl font-bold text-on-background">Kabar <span
                                class="text-secondary">Desa</span></h2>
                        <p class="font-body-md text-on-surface-variant text-lg">Ikuti perkembangan terbaru, pengumuman, dan
                            publikasi kegiatan kemasyarakatan Desa Tulusbesar.</p>
                    </div>
                    <a href="{{ route('publikasi') }}"
                        class="font-label-md text-secondary hover:text-secondary-fixed-dim transition-colors flex items-center gap-xs">
                        Lihat Semua Berita <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-lg">
                    @foreach($news as $index => $berita)
                        <!-- News Card -->
                        <div
                            class="bg-surface-container-lowest rounded-2xl overflow-hidden shadow-sm shadow-[#4A2B1D]/5 border border-surface-dim hover:shadow-xl hover:shadow-[#4A2B1D]/10 transition-all duration-300 transform hover:-translate-y-2 group flex flex-col">
                            <div class="h-56 overflow-hidden relative">
                                @if($index === 0)
                                    <div
                                        class="absolute top-sm right-sm z-10 bg-tertiary-fixed text-on-tertiary-fixed font-label-sm px-2 py-1 rounded-md shadow-md">
                                        Terbaru</div>
                                @endif
                                <img src="{{ empty($berita->image_path) ? asset('images/dummy/hero.jpg') : (Str::startsWith($berita->image_path, 'images/dummy/') ? asset($berita->image_path) : \Illuminate\Support\Facades\Storage::disk('public')->url($berita->image_path)) }}"
                                    alt="{{ $berita->title }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="p-lg flex-grow flex flex-col">
                                <div class="flex items-center gap-sm text-on-surface-variant font-label-sm mb-sm">
                                    <span class="material-symbols-outlined text-[16px]">calendar_today</span>
                                    <time>{{ \Carbon\Carbon::parse($berita->published_at ?? $berita->created_at)->translatedFormat('d M Y') }}</time>
                                </div>
                                <h3
                                    class="font-headline-md text-xl font-bold text-on-surface mb-sm line-clamp-2 group-hover:text-secondary transition-colors">
                                    {{ $berita->title }}</h3>
                                <p
                                    class="font-body-sm text-on-surface-variant text-left line-clamp-3 mb-4 break-words min-w-0 flex-grow">
                                @php $beritaPreview = preg_replace('/\s+/', ' ', trim(strip_tags(preg_replace('/<\/(p|li|h[1-6]|div)>/i', ' ', str_replace(['<br>', '<br/>', '<br />'], ' ', $berita->content))))); @endphp
                                    {{ $beritaPreview }}</p>
                                <a href="{{ route('berita.show', $berita->slug) }}"
                                    class="w-full bg-surface-container hover:bg-primary text-primary hover:text-on-primary font-label-sm py-2 rounded-xl transition-colors border border-outline-variant/50 hover:border-primary flex items-center justify-center gap-2 mt-auto">
                                    Selengkapnya <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <!-- Peta Cerdas / WebGIS Preview Section -->
        <section class="py-16 md:py-24 bg-surface-container-low">
            <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

                    <!-- Left: Maps Embed -->
                    <div
                        class="w-full h-[400px] md:h-[500px] rounded-3xl overflow-hidden shadow-xl border border-outline-variant/30">
                        <iframe
                            src="https://maps.google.com/maps?q=Desa%20Tulusbesar,%20Kec.%20Tumpang,%20Kabupaten%20Malang&t=&z=14&ie=UTF8&iwloc=&output=embed"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>

                    <!-- Right: Village Info & Buttons -->
                    <div class="space-y-8">
                        <div>
                            <h2
                                class="font-display-lg text-4xl md:text-5xl font-bold text-on-background mb-6 uppercase tracking-tight">
                                Desa Tulusbesar
                            </h2>

                            <div class="space-y-4">
                                <div class="flex items-start gap-4 text-on-surface-variant font-body-md">
                                    <span class="material-symbols-outlined mt-1 text-on-surface">location_on</span>
                                    <span>Kantor Desa Tulusbesar, Kec. Tumpang, Kabupaten Malang, Jawa Timur</span>
                                </div>
                                <div class="flex items-center gap-4 text-on-surface-variant font-body-md">
                                    <span class="material-symbols-outlined text-on-surface">call</span>
                                    <a href="tel:+6281333114564"
                                        class="hover:text-primary transition-colors hover:underline">0813-3311-4564</a>
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
                            <div class="flex flex-col sm:flex-row gap-4">
                                <!-- Button WebGIS -->
                                <a href="{{ route('peta') }}"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-primary text-on-primary font-label-md font-bold hover:bg-primary/90 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                                    <span class="material-symbols-outlined text-[20px]">explore</span>
                                    Buka Peta WebGIS
                                </a>
                                <!-- Button Maps -->
                                <a href="https://www.google.com/maps/place/Tulusbesar,+Kec.+Tumpang,+Kabupaten+Malang,+Jawa+Timur/"
                                    target="_blank" rel="noopener noreferrer"
                                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-full bg-surface-container border border-outline-variant/50 text-on-surface font-label-md font-bold hover:bg-surface-variant transition-all hover:border-outline">
                                    <span class="material-symbols-outlined text-[20px]">map</span>
                                    Kunjungi Desa Tulusbesar
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Include Footer here to appear at bottom of scrollable area -->
        <x-footer />
    </div>
@endsection