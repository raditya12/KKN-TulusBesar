@extends('layouts.app')

@section('content')
<style>
    @keyframes moveBatik {
        from { background-position: 0 0; }
        to { background-position: 800px 800px; }
    }
    @keyframes floatWayangLeft {
        0% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(2deg); }
        100% { transform: translateY(0px) rotate(0deg); }
    }
    @keyframes floatWayangRight {
        0% { transform: translateY(0px) scaleX(-1) rotate(0deg); }
        50% { transform: translateY(-30px) scaleX(-1) rotate(-2deg); }
        100% { transform: translateY(0px) scaleX(-1) rotate(0deg); }
    }
    .bg-batik-animated {
        background-image: url('{{ asset("images/batik_pattern.png") }}');
        background-repeat: repeat;
        background-size: 400px;
        animation: moveBatik 90s linear infinite;
        opacity: 0.04;
        pointer-events: none;
    }
    .wayang-silhouette-left {
        background-image: url('{{ asset("images/wayang_silhouette.png") }}');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        animation: floatWayangLeft 12s ease-in-out infinite;
        opacity: 0.05;
        pointer-events: none;
        mix-blend-mode: multiply;
    }
    .wayang-silhouette-right {
        background-image: url('{{ asset("images/wayang_silhouette.png") }}');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        animation: floatWayangRight 15s ease-in-out infinite;
        opacity: 0.05;
        pointer-events: none;
        mix-blend-mode: multiply;
    }
</style>

<div class="w-full overflow-y-auto custom-scrollbar bg-surface-container-lowest relative min-h-screen">
    
    <!-- Animated Javanese Culture Backgrounds -->
    <div class="fixed inset-0 z-0 bg-batik-animated"></div>
    <div class="fixed top-[20%] -left-[10%] w-[500px] h-[500px] md:w-[700px] md:h-[700px] wayang-silhouette-left z-0 hidden sm:block"></div>
    <div class="fixed bottom-0 -right-[5%] w-[400px] h-[400px] md:w-[600px] md:h-[600px] wayang-silhouette-right z-0 hidden sm:block"></div>

    <!-- Content Wrapper to stay above fixed backgrounds -->
    <div class="relative z-10">
        
        <!-- Floating Back Button -->
        <div class="fixed top-24 left-4 lg:left-8 z-50">
            <a href="{{ route('home') }}" class="w-12 h-12 rounded-full bg-surface-container-lowest/80 backdrop-blur-md border border-outline-variant/30 flex items-center justify-center text-on-surface-variant hover:text-primary hover:border-primary shadow-lg transition-all hover:-translate-x-1" title="Kembali ke Beranda">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
        </div>

        <!-- Premium Hero Section -->
        <section class="relative min-h-[70vh] flex items-center justify-center overflow-hidden rounded-b-[3rem] shadow-sm">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Sejarah Desa Tulusbesar" class="w-full h-full object-cover filter contrast-125 brightness-50 mix-blend-overlay">
                <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/70 to-surface-container-lowest/30"></div>
                <!-- Additional batik layer specific to hero for depth -->
                <div class="absolute inset-0 bg-batik-animated opacity-[0.08]"></div>
            </div>
            
            <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin relative z-10 text-center flex flex-col items-center mt-16">
                <span class="px-5 py-2 rounded-full bg-primary/20 text-primary border border-primary/30 font-label-md tracking-[0.2em] uppercase text-sm shadow-xl shadow-primary/10 mb-8 backdrop-blur-md inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">history_edu</span>
                    Babat Tanah Malang
                </span>
                <h1 class="font-display-lg text-5xl md:text-7xl lg:text-8xl font-black text-on-surface leading-tight mb-8 drop-shadow-sm tracking-tight">
                    Sejarah Lengkap <br><span class="text-primary italic">Desa Tulusbesar</span>
                </h1>
                <p class="font-body-lg text-on-surface-variant text-xl md:text-2xl max-w-4xl leading-relaxed drop-shadow-sm font-light">
                    Menelusuri jejak waktu dari Era Kerajaan Mataram, masa kolonial Belanda, hingga terbentuknya desa mandiri dengan pesona seni dan budayanya.
                </p>
            </div>
        </section>

        <!-- Main Content -->
        <div class="max-w-screen-xl mx-auto px-4 lg:px-container-margin py-20 space-y-32">
            
            <!-- Section 1: Asal Usul -->
            <section id="asal-usul">
                <div class="flex flex-col lg:flex-row gap-16 items-center">
                    <div class="lg:w-1/2 relative group">
                        <div class="absolute -inset-4 bg-gradient-to-r from-primary/10 to-secondary/10 rounded-[3rem] transform -rotate-3 group-hover:rotate-0 transition-transform duration-500"></div>
                        <div class="rounded-[2.5rem] overflow-hidden shadow-2xl relative aspect-[4/3] z-10">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Pemandangan Tulusbesar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-8 tracking-tight">Asal Usul & <br><span class="text-primary">Legenda Babat Malang</span></h2>
                        <div class="prose prose-xl prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed relative z-10">
                            <p>
                                Desa Tulusbesar adalah salah satu desa yang terletak tidak jauh dari lereng kaki Gunung Bromo, Semeru dan Tengger bagian barat. Berada pada ketinggian 550-700 mDPL, kondisi desa ini sangat sejuk.
                            </p>
                            <p>
                                Berdasarkan literatur dan keterangan para <em>sesepuh</em> (pinisepuh), sejarah Tulusbesar erat kaitannya dengan legenda <strong>Babat Malang</strong>. Kata <strong>"Mbesar"</strong> berasal dari kata "Mbes" atau sumber air yang besar-besar. Banyaknya Mbes ini mengalir menjadi anak sungai Kali Lanang. Sedangkan kata <strong>"Tulus"</strong> mengandung arti ketulusan warga dalam merawat kelestarian sumber alam dan ekosistem demi kesuburan pertanian.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 2: Kronologi -->
            <section id="kronologi" class="bg-surface-container-low/80 backdrop-blur-md p-10 md:p-16 rounded-[4rem] border border-outline-variant/30 relative overflow-hidden">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

                <div class="text-center max-w-3xl mx-auto mb-20 relative z-10">
                    <span class="font-label-md tracking-[0.2em] text-secondary uppercase mb-4 block">Lintas Zaman</span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-6 tracking-tight">Kronologi Perjalanan Sejarah</h2>
                    <p class="font-body-md text-on-surface-variant text-xl">Catatan peristiwa penting yang melatarbelakangi terbentuknya kawasan Tulusbesar dan sekitarnya.</p>
                </div>
                
                <div class="relative before:absolute before:inset-y-0 before:left-8 md:before:left-1/2 before:-ml-px before:w-1 before:bg-gradient-to-b before:from-primary before:via-secondary before:to-primary/20 space-y-20 z-10">
                    
                    <!-- Timeline Item 1 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:text-right md:pr-16 pl-24 md:pl-0 order-2 md:order-1 mt-4 md:mt-0">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/kadipaten_malang.jpg') }}" alt="Era Kadipaten Malang" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Era Kadipaten Malang</h3>
                            <p class="font-body-md text-on-surface-variant text-lg">Dipimpin oleh Adipati Ronggo Tohjiwo, berpusat di Kuta Bedah, Buring. Wilayah ini dikenal sebagai Malang Kuso (Malang Eng-Kuso) berkat kemakmuran hasil taninya.</p>
                        </div>
                        <div class="absolute left-8 md:left-1/2 -ml-[32px] mt-1 md:mt-0 w-16 h-16 rounded-full bg-surface-container-lowest border-4 border-primary shadow-xl flex items-center justify-center font-display-sm font-bold text-primary z-10 group-hover:bg-primary group-hover:text-on-primary transition-all duration-300 group-hover:scale-110">
                            1614
                        </div>
                        <div class="md:w-5/12 md:pl-16 hidden md:block order-3"></div>
                    </div>

                    <!-- Timeline Item 2 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:pr-16 hidden md:block order-1"></div>
                        <div class="absolute left-8 md:left-1/2 -ml-[32px] mt-1 md:mt-0 w-16 h-16 rounded-full bg-surface-container-lowest border-4 border-primary shadow-xl flex items-center justify-center font-label-md font-bold text-primary z-10 group-hover:bg-primary group-hover:text-on-primary transition-all duration-300 group-hover:scale-110 text-center leading-none">
                            1614<br>-28
                        </div>
                        <div class="md:w-5/12 md:pl-16 pl-24 mt-4 md:mt-0 order-2 md:order-3">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Serangan Mataram" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Serangan Mataram</h3>
                            <p class="font-body-md text-on-surface-variant text-lg">Sultan Agung (Mataram) mengutus Patih Surontanu untuk menyerang Kadipaten Malang. Terjadilah peperangan sengit yang memporak-porandakan wilayah tersebut. Tumenggung Alap-alap membangun pertahanan.</p>
                        </div>
                    </div>

                    <!-- Timeline Item 3 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:text-right md:pr-16 pl-24 md:pl-0 order-2 md:order-1 mt-4 md:mt-0">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Pelarian & Wafatnya Pahlawan" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Pelarian & Wafatnya Pahlawan</h3>
                            <p class="font-body-md text-on-surface-variant text-lg">Senopati Mangun Yudho terdesak dan melarikan diri, lalu dirawat oleh Mbok Rondo Kuning (asal nama Desa <strong>Tulusayu</strong>). Hingga akhirnya beliau moksa di Binangun, dan selimutnya dimakamkan di <strong>Kemulan</strong>.</p>
                        </div>
                        <div class="absolute left-8 md:left-1/2 -ml-[32px] mt-1 md:mt-0 w-16 h-16 rounded-full bg-surface-container-lowest border-4 border-primary shadow-xl flex items-center justify-center font-label-md font-bold text-primary z-10 group-hover:bg-primary group-hover:text-on-primary transition-all duration-300 group-hover:scale-110 text-center leading-none">
                            1638<br>-43
                        </div>
                        <div class="md:w-5/12 md:pl-16 hidden md:block order-3"></div>
                    </div>
                    
                    <!-- Timeline Item 4 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:pr-16 hidden md:block order-1"></div>
                        <div class="absolute left-8 md:left-1/2 -ml-[32px] mt-1 md:mt-0 w-16 h-16 rounded-full bg-surface-container-lowest border-4 border-primary shadow-xl flex items-center justify-center font-display-sm font-bold text-primary z-10 group-hover:bg-primary group-hover:text-on-primary transition-all duration-300 group-hover:scale-110">
                            1743
                        </div>
                        <div class="md:w-5/12 md:pl-16 pl-24 mt-4 md:mt-0 order-2 md:order-3">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Penguasaan VOC" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Penguasaan VOC</h3>
                            <p class="font-body-md text-on-surface-variant text-lg">Berdasarkan Perjanjian Mataram & VOC, wilayah Malang Timur diawasi VOC. Pembukaan lahan perkebunan tebu dan kopi dilakukan secara masif.</p>
                        </div>
                    </div>

                    <!-- Timeline Item 5 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:text-right md:pr-16 pl-24 md:pl-0 order-2 md:order-1 mt-4 md:mt-0">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Berdirinya Desa Tulusbesar" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-secondary mb-3">Berdirinya Desa Tulusbesar</h3>
                            <p class="font-body-md text-on-surface-variant text-lg">Setelah Perang Jawa, Senopati Mangun Yudho diyakini oleh masyarakat sebagai tokoh yang melakukan <em>babat alas</em> dan menamakan daerah pemukiman baru ini dengan nama <strong>"Tulusbesar"</strong>.</p>
                        </div>
                        <div class="absolute left-8 md:left-1/2 -ml-[32px] mt-1 md:mt-0 w-16 h-16 rounded-full bg-surface-container-lowest border-4 border-secondary shadow-xl flex items-center justify-center font-display-sm font-bold text-secondary z-10 group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300 group-hover:scale-110">
                            1830
                        </div>
                        <div class="md:w-5/12 md:pl-16 hidden md:block order-3"></div>
                    </div>

                </div>
            </section>

            <!-- Section 3: Cerita Warga -->
            <section id="versi-warga">
                <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
                    <span class="w-16 h-16 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-[32px]">auto_stories</span>
                    </span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-6 tracking-tight">Tokoh & Punden Desa</h2>
                    <p class="font-body-md text-on-surface-variant text-xl">Kisah lisan yang turun-temurun dan makam para leluhur yang dihormati di berbagai dusun (Versi Warga).</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
                    <!-- Card 1 -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2rem] border border-outline-variant/30 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Mbah Mergo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1">
                            <h4 class="font-headline-sm text-2xl font-bold text-on-surface mb-4">Mbah Mergo & Mbah Kerik</h4>
                            <p class="font-body-md text-on-surface-variant text-justify">Memiliki nama asli Ronggo Wijoyo. Bersama cantriknya, Mbah Kerik (Pekik Ontokusumo), mereka bertugas mendatangkan warga untuk berdomisili di Tulusbesar. Makamnya berada di pemakaman umum Krajan.</p>
                        </div>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2rem] border border-outline-variant/30 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Mbah Ingsun" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1">
                            <h4 class="font-headline-sm text-2xl font-bold text-on-surface mb-4">Mbah Ingsun & Mbah Latif</h4>
                            <p class="font-body-md text-on-surface-variant text-justify">Tokoh yang babad alas dan bedah kerawang di Dusun Sumbersari. Makam Mbah Latif dirawat sebagai punden pahlawan desa, di mana warga rutin melakukan Istiqosah setiap Jumat Legi.</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2rem] border border-outline-variant/30 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Mbok Rondo Kuning" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1">
                            <h4 class="font-headline-sm text-2xl font-bold text-on-surface mb-4">Mbok Rondo Kuning</h4>
                            <p class="font-body-md text-on-surface-variant text-justify">Perempuan berbudi baik yang merawat Senopati Mangun Yudho saat terluka. Makamnya terletak di Dusun Prapatan dan selalu dirawat serta menjadi pusat tradisi barikan pada bulan Muharram.</p>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2rem] border border-outline-variant/30 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Mbah Talpuk" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1">
                            <h4 class="font-headline-sm text-2xl font-bold text-on-surface mb-4">Mbah Talpuk</h4>
                            <p class="font-body-md text-on-surface-variant text-justify">Makamnya terletak di area pedanyangan Krajan Kulon. Peninggalannya berupa pondasi batu bata merah berukuran besar peninggalan zaman Belanda dan uang koin VOC pernah ditemukan di area ini.</p>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2rem] border border-outline-variant/30 shadow-sm hover:shadow-xl transition-all duration-300 group overflow-hidden flex flex-col">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Makam Lainnya" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-surface-container-lowest to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1">
                            <h4 class="font-headline-sm text-2xl font-bold text-on-surface mb-4">Makam & Petilasan Lainnya</h4>
                            <p class="font-body-md text-on-surface-variant text-justify">Terdapat makam Mbah Srimunah (Krajan), Mbah Arimi (Kemulan), Mbah Kendil, dan Mbah Ketang. Semua punden ini menjadi simbol pelestarian budaya ritual desa yang dijaga warga.</p>
                        </div>
                    </div>
                    
                    <!-- Card 6 -->
                    <div class="bg-primary/95 backdrop-blur-sm rounded-[2rem] shadow-xl group overflow-hidden flex flex-col text-on-primary">
                        <div class="h-48 overflow-hidden relative">
                            <img src="{{ asset('images/dummy/wisata_hero.jpg') }}" alt="Petilasan Mangun Dharmo" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 mix-blend-overlay opacity-60">
                            <div class="absolute inset-0 bg-gradient-to-t from-primary/95 to-transparent"></div>
                        </div>
                        <div class="p-8 pt-2 flex-1 relative z-10">
                            <h4 class="font-headline-sm text-2xl font-bold mb-4">Petilasan Mangun Dharmo</h4>
                            <p class="font-body-md text-on-primary/90 text-justify">Terletak di Dusun Kemulan, bangunannya direnovasi menjadi Joglo khas Jawa. Terdapat legenda bahwa yang terkubur di dalamnya hanyalah selimut (kemul) sang Senopati, bukan jasadnya.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: Zaman Belanda -->
            <section id="zaman-belanda">
                <div class="bg-surface-container/90 backdrop-blur-md border border-outline-variant/30 p-8 md:p-16 rounded-[4rem] shadow-sm relative overflow-hidden flex flex-col md:flex-row items-center gap-16">
                    <!-- Decorative Elements -->
                    <div class="absolute -right-32 -bottom-32 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
                    
                    <div class="md:w-1/2 relative z-10" style="text-align: center; padding: 2rem 0;">
                    <img src="{{ asset('images/gapura.jpg') }}" alt="Gapura Desa Tulusbesar" style="width: 100%; max-width: 320px; height: 420px; object-fit: cover; border-radius: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); transform: rotate(2deg); filter: sepia(0.3) contrast(1.25); display: inline-block; background-color: #e5e7eb; margin-bottom: 1.5rem;">
                    <p class="text-sm md:text-base text-center text-on-surface-variant font-medium italic rotate-2 px-6">
                        "Foto gapura masuk Desa Tulusbesar dari Dusun Ronggowuni pada masa kepemimpinan Bapak Supeno"
                    </p>
                </div>

                    <div class="md:w-1/2 relative z-10">
                        <span class="font-label-md text-secondary tracking-widest uppercase mb-4 block font-bold">Administrasi Hindia Belanda</span>
                        <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-8 tracking-tight">Penggabungan Desa <br>(Tahun 1870)</h2>
                        <div class="prose prose-xl prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed">
                            <p>
                                Pada awalnya wilayah ini terdiri dari dua entitas desa yang terpisah, yaitu <strong>Desa Tulusayu</strong> (membawahi pedukuhan Tulusayu Prapatan, Kemulan, dan Baran Tulusayu/Sumbersari) dan <strong>Desa Mbesar</strong> (membawahi Mbesar Kulon dan Mbesar Wetan).
                            </p>
                            <p>
                                Mengingat jumlah penduduk dan luas wilayah Desa Tulusayu yang kecil, Pemerintah Hindia Belanda memutuskan untuk menggabungkan desa tersebut. Melalui mekanisme undian antara menggabung ke Desa Mbesar atau Desa Belung, hasilnya jatuh pada Desa Mbesar.
                            </p>
                            <p>
                                Maka terbentuklah nama baru <strong>"Desa Tulusbesar"</strong> secara administratif. Formasi ini bertahan hingga sekarang, membawahi dusun-dusun yang kaya akan budaya dan kesuburan alamnya.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 5: Kepemimpinan -->
            <section id="kepemimpinan">
                <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
                    <span class="font-label-md tracking-[0.2em] text-primary uppercase mb-4 block">Garis Tangan Pemimpin</span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-6 tracking-tight">Sejarah Kepemimpinan Desa</h2>
                    <p class="font-body-md text-on-surface-variant text-xl">Daftar Petinggi, Karteker, Penjabat (Pj), hingga Kepala Desa definitif dari masa ke masa.</p>
                </div>

                <div class="bg-surface-container-lowest/90 backdrop-blur-md rounded-[3rem] border border-outline-variant/40 shadow-xl overflow-hidden relative">
                    <div class="overflow-x-auto relative z-10">
                        <table class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-surface-container-low/50 text-on-surface-variant font-label-md border-b-2 border-outline-variant/50 uppercase tracking-widest text-sm">
                                    <th class="px-8 py-6">Periode Masa Bhakti</th>
                                    <th class="px-8 py-6">Nama Pejabat</th>
                                    <th class="px-8 py-6">Jabatan / Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/30 text-lg">
                                <!-- Belanda -->
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Era Belanda</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Bapak Noni, Temah, Mini
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-surface-variant rounded-lg text-sm">Petinggi Desa</span></td>
                                </tr>
                                <!-- 1951 -->
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1951 – 1963</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Abdul Razak Rekso Dihardjo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1964 – 1965</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Tawi
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1966 – 1969</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Karto Prawiro Kirun
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1970 – 1971</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Wasis
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1972 – 1973</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Mochamad Winardi
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1973 – Mar 1975</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Supeno Niti Mangun Kusumo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Apr 1975 – Sep 1975</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Asan Rachmad
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-sm font-bold">Pjs (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1975 – Apr 1989</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Kasnawi Noto Karyo Wibowo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Mei 1989 – Sep 1998</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Sarkam Rekso Mangku Wibowo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1998 – Mar 2013</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Setyo Adi, S.Pd.
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Apr 2013 – Jul 2019</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Sri Widarti, S.Pd
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Agt 2019 – Nov 2021</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Hudi Mariono
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Des 2021 – Nov 2022</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Lailia Kurniawati, ST., MM
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-sm font-bold">Pj Kepala Desa (Ditunjuk)</span></td>
                                </tr>
                                <tr class="bg-primary/5 hover:bg-primary/10 transition-colors">
                                    <td class="px-8 py-6 font-label-xl text-primary whitespace-nowrap">Des 2022 – Sekarang</td>
                                    <td class="px-8 py-6 font-display-sm text-primary font-black flex items-center gap-3">
                                        <img src="{{ asset('images/dummy/kades.jpg') }}" class="w-12 h-12 rounded-full object-cover border-2 border-primary shadow-sm" alt="">
                                        Sirat Yudin
                                    </td>
                                    <td class="px-8 py-6 font-body-md text-on-surface-variant"><span class="px-4 py-2 bg-primary text-on-primary rounded-xl text-sm font-bold shadow-md">Kades PAW (Pemilihan)</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Section 6: Pilkades PAW -->
            <section id="pilkades-paw">
                <div class="bg-tertiary-container/90 backdrop-blur-md text-on-tertiary-container p-10 md:p-16 rounded-[4rem] shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center gap-12 border border-tertiary/20">
                    <!-- Pattern Background -->
                    <div class="absolute inset-0 opacity-[0.03] mix-blend-overlay bg-batik-animated"></div>
                    
                    <div class="md:w-2/3 relative z-10">
                        <span class="font-label-md tracking-[0.2em] uppercase mb-4 block text-on-tertiary-container/80 font-bold">Catatan Demokrasi Baru</span>
                        <h2 class="font-display-md text-4xl md:text-5xl font-black mb-6 tracking-tight">Pilkades Pergantian Antar Waktu 2022</h2>
                        <div class="prose prose-xl prose-p:text-on-tertiary-container/90 prose-p:text-justify prose-p:leading-relaxed">
                            <p>
                                Sejarah mencatat peristiwa penting pada 17 November 2022. Desa Tulusbesar menggelar Pilkades PAW (Pergantian Antar Waktu) untuk pertama kalinya guna mengisi kekosongan kursi kepemimpinan yang sisa masanya lebih dari satu tahun. 
                            </p>
                            <p>
                                Berbeda dengan Pilkades biasa, pemilihan ini menggunakan sistem keterwakilan tokoh masyarakat (251 pemilih). <strong>Bapak Sirat Yudin</strong> memenangkan pemilihan ini. Menariknya, ini adalah kali pertama dalam sejarah Tulusbesar, Kepala Desa tidak berasal dari Dusun Krajan, melainkan dari Dusun Prapatan.
                            </p>
                        </div>
                    </div>
                    
                    <div class="md:w-1/3 relative z-10 flex justify-center">
                        <div class="relative group">
                            <div class="absolute -inset-4 bg-gradient-to-r from-tertiary to-secondary rounded-full blur-lg opacity-50 group-hover:opacity-80 transition-opacity duration-500"></div>
                            <div class="w-64 h-64 md:w-72 md:h-72 rounded-full border-8 border-surface-container-lowest shadow-2xl overflow-hidden shrink-0 relative z-10 transform transition-transform duration-500 group-hover:scale-105">
                                <img src="{{ asset('images/dummy/kades.jpg') }}" alt="Bapak Sirat Yudin" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <x-footer />
    </div>
</div>
@endsection
