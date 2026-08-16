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
    /* KTI Paragraph Formatting */
    .kti-format p {
        text-align: justify !important;
        margin-bottom: 1.5rem !important;
        line-height: 1.8 !important;
        display: block !important;
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
            
            <!-- Section 1: Asal Usul & Legenda Babat Malang -->
            <section id="asal-usul">
                <div class="text-center max-w-4xl mx-auto mb-16 relative z-10">
                    <span class="px-4 py-1.5 rounded-full bg-primary/10 text-primary border border-primary/20 font-label-sm tracking-widest uppercase mb-6 inline-block">Legenda Babat Malang</span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-8 tracking-tight">Sejarah Desa <span class="text-primary">Tulusbesar</span></h2>
                </div>

                <div class="max-w-7xl mx-auto bg-surface-container-lowest/80 backdrop-blur-md p-8 md:p-12 lg:p-16 rounded-[3rem] shadow-xl border border-outline-variant/30 relative z-10">
                    
                    <!-- Banner Image -->
                    <div class="mb-12 relative group rounded-[2rem] overflow-hidden shadow-md aspect-[21/9]">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent z-10"></div>
                        <img src="{{ asset('images/GapuraBaru.png') }}" alt="Gapura Desa Tulusbesar" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-1000">
                        <div class="absolute bottom-6 md:bottom-10 left-8 md:left-12 z-20">
                            <span class="px-3 py-1 bg-primary/90 text-on-primary text-xs font-bold uppercase tracking-wider rounded-full mb-3 inline-block shadow-sm">Ikon Desa</span>
                            <h3 class="text-white font-display-md text-2xl md:text-4xl font-bold tracking-wide">Gapura Tulusbesar</h3>
                        </div>
                    </div>

                    <!-- 2-Column Magazine Layout -->
                    <div x-data="{ expanded: false }" class="relative">
                        <div class="kti-format prose prose-lg prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed prose-strong:text-primary prose-strong:font-bold columns-1 lg:columns-2 gap-10 lg:gap-16 max-w-none transition-all duration-700 relative" :class="expanded ? 'pb-4' : ''">
                        <p>
                            Desa Tulusbesar adalah salah satu desa yang terletak tidak jauh dari lereng kaki Gunung Bromo, Semeru dan Tengger bagian barat. Dengan topografi berupa daratan dan perbukitan serta berada dalam ketinggian antara 500-700 mDPL, sehingga kondisi desa ini betul-betul dingin dan sejuk. Berdasarkan literatur yang ada dan hasil keterangan yang didapat dari para sesepuh dan pinisepuh di desa sebagai narasumber, maka terjadinya Desa Tulusbesar erat sekali hubungannya dengan desa-desa yang ada di sekitarnya dalam wilayah Kabupaten Malang. Asal usul Desa Tulusbesar ada kaitannya dengan legenda Babat Malang, yang isinya sebagai berikut:
                        </p>
                        <p>Pada tahun 1614 terdapat kerajaan Mataram (Yogyakarta) dan berkuasa seorang raja bernama Sultan Agung, kerajaan ini mempunyai wilayah Kadipaten yang terletak jauh di sebelah timur (Brang Wetan) dan berkuasa seorang bernama Ronggo Tohjiwo dan mempunyai adik putri bernama Proboretno. Sultan Agung memerintahkan Patih Mangun Yudho (Mangun Dharmo) dan Tumenggung Joyodipo untuk membuat sayembara, barang siapa yang dapat membuka hutan di wilayah timur akan dihadiahi atau dikawinkan dengan adiknya bernama Sri Tanjungsari. Ternyata Ronggo Tohjiwo dibantu adiknya Proboretno berhasil membuka hutan dan terdapat gundukan atau gunung yang melintang, daerah ini dikenal dengan nama <strong>Gunung Buring Bumiayu</strong>, selanjutnya Ronggo Tohjiwo menikah dengan Sri Tanjungsari dan membuat kadipaten baru yaitu Kadipaten Malang (daerah Dungloncing Kota Lama). Roda pemerintahan berjalan lancar dengan hasil tani yang subur, rakyat makmur, terkenal dengan sebutan <strong>Malang Kuso</strong> (Malang-Eng-Kuso) yang artinya rakyat makmur dari hasil tani kopi dan padi Jawa, dan setiap tahunnya diharuskan memberi upeti kepada Sultan Agung di Mataram.</p>
                        <div x-show="expanded" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="break-inside-auto">
                            <p>Kemudian datang ke Kadipaten Malang seorang Aris Japanan Sidoarjo dengan nama Sumolewo, dia bermaksud melamar Proboretno, namun lamarannya ditolak sehingga dia berbuat onar. Akhirnya Proboretno membuat sayembara, barang siapa yang dapat membuka pintu benteng Goa Bumiayu (Gunung Buring) itulah yang jadi jodohnya. Sumolewo sadar bahwa sayembara itu berat, maka dia kembali ke Nongkojajar Tengger untuk minta petunjuk gurunya bernama Sidik Wacono. Sumolewo yang sangat cinta kepada Proboretno ternyata oleh gurunya dilarang karena bukan jodohnya, maka Sumolewo marah dan sang guru dibunuhnya. Arwah sang guru berkata (ono suoro gak ono rupo, jw.) bahwa besok matinya Sumolewo dibunuh oleh seorang laki-laki yang memakai anting-anting dan hal itu dipahami oleh Sumolewo, maka setiap ada atau bertemu seorang Madura di Kadipaten Malang pasti dibunuh tanpa sebab apapun.</p>
                        <p>Adipati Cakraningrat yang berkedudukan di Sampang Madura mendengar kekejaman yang dilakukan oleh Sumolewo Aris Japanan ini, maka Adipati mengutus putra bernama Panji Pulang Jiwo untuk datang ke Kadipaten Malang. Bertemulah Panji Pulang Jiwo dengan Sumolewo, akhirnya terjadi peperangan yang sengit setelah Panji Pulang Jiwo berhasil membuka benteng Goa Gunung Buring Bumiayu. Dalam peperangan Sumolewo terlepas dan kuda yang dinaiki lepas (mbedal ,jw.) , maka daerah itu terkenal dengan nama <strong>Bedali Lawang</strong>. Akhirnya Sumolewo terus mundur dan disoraki oleh orang banyak, maka daerah ini dinamakan <strong>Kali Surak</strong>, dan terlihat darah (getih) yang berceceran maka daerah ini dinamakan <strong>Kali Getih</strong> yang berada di daerah Lawang, dan akhirnya Sumolewo mati dibunuh oleh Panji Pulang Jiwo.</p>
                        <p>Kemudian setelah peperangan selesai, maka Panji Pulang Jiwo dikawinkan dengan adik Ronggo Tohjiwo yaitu Proboretno dan menetap di Kepanjian wilayah Kadipaten Malang. Kedudukan Adipati Ronggo Tohjiwo semakin kuat dengan adanya Senopati baru, yaitu Adipati Panji Pulang Jiwo. Dari sinilah awal alkisah perjalanan Patih Mangun Yudho (Mangun Dharmo) yang telah bergabung di Kadipaten Malang sebagai senopati dan terkenal dengan sebutan "Pendekar Malang".</p>
                        <p>Dengan adanya senopati baru, maka Senopati Mangun Yudho (Mangun Dharmo) merasa Kadipaten Malang cukup mampu dan tangguh, sehingga tidak perlu lagi memberi upeti kepada Sultan Agung di Mataram (Yogyakarta). Tidak patuhnya Kadipaten Malang terhadap Mataram, menjadikan Sultan Agung marah dan mengutus Patih Surontanu dengan prajurit laki-laki maupun perempuan untuk menyerang Kadipaten Malang melalui daerah Blitar. Dalam perjalanan menuju Kadipaten Malang, para prajurit merasa kehausan karena kehabisan air minum, mereka berusaha mencari air namun tidak ada, maka putri Mataram menancapkan tusuk kondenya dengan kesaktiannya pada sebuah pohon Pucang sebangsa pohon palem dan keluar airnya yang selanjutnya dibuat minum para prajurit beramai-ramai, daerah ini terkenal dengan nama <strong>Sumberpucung</strong>.</p>
                        <p>Kemudian Patih Surontanu terus bergerak ke utara beserta para prajurit, dan terjadilah perang besar-besaran melawan para prajurit Kadipaten Malang, banyak prajurit Mataram maupun Malang yang jatuh meninggal (tibo pating gumebruk ,jw.) yang daerah ini akhirnya terkenal dengan nama <strong>Ngebruk</strong>. Para prajurit Malang terdesak mundur sampai ke tempat kediaman Panji Pulang Jiwo, karena Senopati Mangun Yudho tidak mampu menahan serangan Patih Surontanu dengan para prajurit Mataram. Terjadilah peperangan antara Patih Surontanu dengan Panji Pulang Jiwo di Kepanjian atau yang sekarang terkenal dengan nama <strong>Kepanjen</strong>. Para prajurit Malang kocar-kacir dan Panji Pulang Jiwo melarikan diri.</p>
                        <p>Patih Surontanu adalah Senopati Mataram yang tangguh dan berpengalaman di medan perang, maka dia bersiasat membuat panggung atau gubuk tinggi dan diberi golekan persis seperti Proboretno, istri Panji Pulang Jiwo dan diisukan Proboretno telah meninggal dunia, jasadnya ditaruh di panggung atau gubuk tersebut, yang berdiri di atas kolam (blumbang) di dalamnya diberi bambu runcing. Mendengar isu bahwa istrinya meninggal dunia, maka Panji Pulang Jiwo keluar dari persembunyiannya dan langsung dengan sedih naik ke atas panggung atau gubuk, saat itulah para prajurit Mataram merobohkan panggung dan Panji Pulang Jiwo jatuh tertancap bambu runcing apus tersebut dan wafat seketika, daerah inilah yang kemudian dinamakan <strong>Desa Panggung</strong>.</p>
                        <p>Prajurit Malang terdesak mundur ke utara, tapi masih terus terjadi peperangan sengit, banyak korban mati antara prajurit Malang dan Mataram, para penduduk banyak yang melayat dan memberi sedekah untuk biaya penguburannya, sehingga dengan di bawah pimpinan Senopati Mangun Yudho dan Tumenggung Joyodipo, prajurit Malang mundur ke timur utara, terjadilah peperangan sengit di suatu tempat dan Tumengung Joyodipo wafat serta dimakamkan pula, sehingga daerah ini dikenal dengan nama <strong>Jodipan</strong>, sedangkan Senopati Mangun Yudho lari ke utara ke tempat kosong (oro-oro ,jw.), dikejar Patih Surontanu, ditumbak tapi tumbaknya putus separo (rompal ,jw.), maka daerah oro-oro tersebut dikenal dengan nama <strong>Alun-alun</strong> dan Patih Surontanu mengejar terus ke timur utara, kemudian berhenti karena Senopati Mangun Yudho hilang bersembunyi, sekarang tempat ini dinamakan <strong>Rampal</strong>. Kemudian di tempat ini Patih Surontanu bersumpah, siapa saja sebagai seorang pejabat negara atau kerajaan berani memasuki wilayah Rampal, maka jabatannya akan rampal (copot).</p>
                        <p>Patih Surontanu terus mengejar Senopati Mangun Yudho yang sudah luka parah, ke arah utara timur bertemu dengan Padepokan atau Pertapan dengan nama Pusung Buntung, seorang Caroko Negoro putra selir Brawijaya V (selir ke 39) yang sedang bertapa (mendito), kemudian daerah ini dinamakan <strong>Mendit</strong>. Pandito Caroko Nagoro punya cantrik 2 orang yaitu Mpu Kalisari asal Tengger sebagai Pande (tukang pembuat senjata tajam) dan Romo Sodik Ibrahim dari Nggambang Plinggisan. Terjadilah peperangan, namun Mpu Kalisari terbunuh dan dimakamkan di Mendit terkenal dengan sebutan <strong>Mbah Kabul</strong>, sedangkan Romo Sodik Ibrahim karena ilmu kesaktiannya murco/musno (hilang jasadnya), sedang sandalnya yang terbuat dari kayu (bungkul/bangkiak) disabda oleh Patih Surontanu dengan kesaktiannya menjadi Watu Junjung, saat ini ada di Lowoksuruh Mendit dan anak buahnya juga disabda menjadi kera dengan jumlah 44 ekor.</p>
                        <p>Senopati Mangun Yudho bertemu Caroko Nagoro yang sedang mendito/bertapa dan menyuruh lari ke timur selatan untuk berhenti mendito/bertapa dan disuruh mencari guru ngaji saja, tempat itu dinamakan <strong>Madyopuro</strong>, asal kata Bahasa Jawa <em>Dalane Nyuwun Pangapuro</em> dan dituruti oleh Caroko Nagoro menjadi guru ngaji dengan sebutan Kyai Ageng Gribig, saat ini makamnya terletak di sebelah selatan Madyopuro.</p>
                        <p>Sedangkan Senopati Mangun Yudho lari ke timur dalam kondisi luka dan lapar dengan diikuti beberapa prajurit saja , saat sedang istirahat melihat tanaman yang sebenarnya adalah Kayu apu namun dikiranya Gobis/Kubis, sehingga tempat itu dinamakan <strong>Bogis</strong>. Sedangkan Patih Surontanu terus mengejar jejak pelarian Senopati Mangun Yudho. Ketika berhenti istirahat di suatu tempat, prajurit andalannya (Prajurit Sentono Projo) karena terluka akibat peperangan meninggal dunia dan dimakamkan di situ dengan alat senjata, kemudian daerah itu dinamakan <strong>Urek-Urek</strong>.</p>
                        <p>Dari Bogis, Senopati Mangun Yudho terus ke arah timur melihat pohon Kayu Lengki sebangsa Jowar terletak di gundukan/putukan dan digunakan untuk istirahat, tempat ini dinamakan <strong>Patuk Lengki</strong> (Bunut Wetan) kemudian Senopati berjalan terus ke arah timur bertemu pohon pakis berjajar-jajar dan disebelahnya ada yang kembar, maka tempat ini dinamakan <strong>Pakis Jajar</strong> dan <strong>Pakis Kembar</strong>. Merasa keadaan aman dari pengejaran Patih Surontanu, Senopati Mangun Yudho kembali ke barat istirahat di suatu tempat dengan tujuan mendirikan gubuk/pesanggrahan, dari tempat ini membuat jalan sempalan ke arah selatan dengan tujuan agar jejaknya tidak mudah dilacak. Batas akhir membuat jalan ini (embah-embahan ,jw.) dinamakan desa <strong>Mbamban</strong>, kemudian berdirilah sebuah pesanggrahan dan ternyata banyak warga Kadipaten Malang pencari kayu bakar yang numpang/nunut istirahat di situ, akhirnya tempat ini dinamakan <strong>Bunut</strong>.</p>
                        <p>Dengan didengarnya kabar bahwa prajurit Mataram tidak jauh dari tempat ini yaitu berada di sebelah baratnya, maka Senopati Mangun Yudho melanjutkan pelariannya ke timur pada suatu tempat terus mencari jalan akhirnya kembali ke tempat itu lagi (bingung atau mutar saja), sehingga daerah itu diibaratkan seperti pusaka cakra, maka dinamakan desa <strong>Cokro</strong> dan tempat berhentinya dinamakan <strong>Dumpul</strong> (mandeg atau kempal). Perjalanan Senopati Mangun Yudho tertatih-tatih berhenti tidak kuat (leren suwe/leren jero), akhirnya tempat ini dinamakan desa <strong>Jeru</strong>. Peristirahatan Senopati Mangun Yudho ini sangat lama sekali sampai berbulan-bulan, sedangkan pengejaran Patih Surontanu lambat karena banyak prajuritnya yang luka parah, sehingga salah satu wakilnya terkenal dengan sebutan Raden (adalah kerabat Keraton Mataram) wafat , tempat wafatnya Raden tersebut dinamakan desa <strong>Kradenan</strong>, tempat ini juga menjadi tempat peristirahatan prajurit Mataram berbulan-bulan lamanya.</p>
                        <p>Setelah kondisi Senopati Mangun Yudho agak pulih, bersama prajuritnya melanjutkan perjalanan ke selatan bertemu pohon besar roboh menghalangi jalan , kemudian diangkat bersama-sama (rame-rame) tempat ini dinamakan desa <strong>Malangsuko</strong>. Lalu terus ke selatan istirahat di suatu tempat dekat sungai, karena tidak kuat panas akibat kena tombak, Senopati Mangun Yudho berjemur di atas batu besar yang kemudian dinamakan Desa <strong>Tumpang</strong>.</p>
                        <p>Di sisi lain Patih Surontanu terus melakukan pengejaran, akhirnya Sang Patih sampai di Desa Tumpang, merasa pengejarannya tidak berbuah hasil maka berhenti untuk istirahat. Sedangkan Senopati Mangun Yudho lari ke selatan timur bertemu dengan seorang perempuan bernama Mbok Rondo Kuning, bersama anaknya perempuan satu (makamnya ada di Prapatan Tulusayu). Senopati Mangun Yudho dirawat oleh Mbok Rondo Kuning, waktu tidur diberi kain selimut panjang (jarik) sebelum melanjutkan pelariannya. Senopati Mangun Yudho memberi nama tempat kediaman Mbok Rondo Kuning dengan sebutan Desa <strong>Tulusayu</strong>, ini diambil dari sifat Mbok Rondo Kuning yang budinya baik (ayu ) juga cantik.</p>
                        <p>Karena ketakutan dikejar prajurit Mataram, maka Senopati Mangun Yudho lari ke selatan pada suatu tempat lukanya semakin parah sampai tulangnya kelihatan (Wates Belung), maka daerah ini dinamakan Desa <strong>Belung</strong> dan selatannya dinamakan desa <strong>Wates</strong>. Merasa sudah tidak kuat lagi, akhirnya Senopati kembali ke utara berhenti di suatu tempat bertemu Mbok Rondo Kuning lagi, dikira sudah lepas dari pengejaran Patih Surontanu ternyata Patih Surontanu dan prajuritnya berada tidak jauh di sebelah utara barat yaitu berada di Desa Tumpang, maka dengan tergesa-gesa Senopati Mangun Yudho lari ke timur masuk hutan dengan dua pengawal prajuritnya, dan berhenti di suatu tempat, akhirnya karena kesaktiannya Senopati Mangun Yudho murco/musno (hilang bersama raganya) dan tempat ini dikenal dengan nama <strong>Binangun</strong>.</p>
                        <p>Dalam pelariannya ke timur masuk hutan, selimut kain panjang (kemul jarik) pemberian Mbok Rondo Kuning tertinggal, atas gagasan Mbok Rondo Kuning maka kain panjang yang berlumuran darah itu dibuatkan pusara/kuburan seakan-akan Senopati Mangun Yudho telah wafat. Akhirnya daerah ini dikenal dengan daerah <strong>Kemulan</strong> dan terdapat pesarean Mangun Yudho (Mangun Dharmo).</p>
                        <p>Dengan hilangnya Senopati di daerah hutan Binangun, dua orang prajurit pengawal setia Senopati Mangun Yudho kembali ke barat membuat sebuah bangunan gubuk yang dikenal dengan nama Padepokan Mangir, terletak di tanah gundukan/tanjakan yang dikenal dengan nama jurang Kanting dan mereka berdua menamakan dirinya Mbah Kerik dan Mbah Mergo. Selang beberapa waktu Mbah Kerik dan Mbah Mergo berkeinginan mendirikan perkampungan, kemudian mereka menebang hutan (babat alas) ke arah utara dan disitu dijumpai sumber mata air yang besar-besar, maka daerah tersebut dinamakan Desa <strong>Mbesar</strong>, dari asal kata mbes-mbesan air yang besar. Mbah Kerik dan Mbah Mergo makamnya berada di pemakaman umum Besar Barat dan dikenal sebagai Bedah Kerawang Desa Mbesar sampai sekarang. Sebagai generasi penerus selanjutnya dari Mbah Kerik dan Mbah Mergo diantaranya adalah seorang perempuan bernama Mbah Srimunah yang makamnya berada di Mbesar Timur.</p>
                        <p>Dari beberapa tempat makam atau pesarean dari para leluhur diantaranya Mbok Rondo Kuning di Tulusayu Prapatan, Mbah Mangun Yudho (Mangun Dharmo) di Kemulan, Mbah Kerik dan Mbah Margo serta Mbah Srimunah di Mbesar oleh warga masyarakat Desa Tulusbesar masih dikeramatkan atau mempunyai nilai historis dan sakral sebagai para nenek moyangnya atau para leluhurnya.</p>
                        <p>Kemudian di sisi lain Patih Surontanu dengan prajuritnya setelah istirahat di Desa Tumpang melanjutkan pengejaran ke arah selatan timur, setelah sampai di suatu tempat mereka menjumpai pusara atau kuburan Senopati Malang Mangun Yudho, sehingga mereka menganggap bahwa orang yang dicari-cari selama ini ternyata sudah meninggal dunia. Setelah yakin bahwa Senopati Mangun Yudho meninggal dunia, Patih Surontanu beserta prajuritnya kembali ke utara barat menuju Kadipaten Malang untuk menyerang pusat pemerintahan.</p>
                        <p>Dalam perjalanannya Patih Surontanu beserta prajuritnya mengalami berbagai kejadian aneh, diantaranya : tertinggalnya sebuah bokor milik prajurit di sebuah perkampungan, jadilah desa yang saat ini bernama Desa <strong>Bokor</strong> ; menjumpai perkampungan yang banyak tanaman pohon jambe, jadilah daerah <strong>Karang Jambe</strong> ; mengenang sambil istirahat di perkampungan dalam keadaaan selamat selama pengejaran Senopati Mangun Yudho, jadilah Desa <strong>Slamet</strong> ; bertemu dengan seorang perempuan seperti Putri Banjaransari (putri keraton yang indah ing sulistyo warno) jadilah Desa <strong>Banjarsari</strong> ; menjumpai dataran rendah atau kedung dan banyak orang membuat batu-bata di tempat itu, jadilah daerah <strong>Kedung Boto</strong> ; menjumpai perkampungan penuh dengan tanaman pohon cemara, jadilah daerah <strong>Cemoro Kandang</strong>.</p>
                        <p>Kemudian perjalanan diteruskan ke arah barat melewati Madyopuro dan Gribig, setelah berada di Kedung Kandang, Patih Surontanu menata barisan prajurit dan bersiap-siap untuk menyerang melalui pintu belakang pusat pemerintahan Kadipaten Malang, maka pecahlah perang besar-besaran di kota Malang (bedah kuto Malang ,jw.) dan tempat tersebut terkenal dengan nama <strong>Kuto Bedah</strong>.</p>
                        <p>Pada peperangan yang terjadi di Kuto Bedah ini prajurit Malang terdesak (kocar-kacir) akibat serangan dan gempuran dari Patih Surontanu beserta prajuritnya, sehingga pusat pemerintahan Kadipaten Malang dapat dikuasai, sedangkan Adipati Ronggo Tohjiwo beserta kerabatnya melarikan diri dan menghilang tanpa jejak.</p>
                        <p>Setelah peperangan usai kemenangan berada di pihak Mataram maka prajurit Mataram kembali pulang dan Kadipaten Malang dikuasai oleh Kerajaan Mataram, maka dinobatkan sebagai putra kerajaan bernama Sultan Alamsyah sebagai penguasa baru di Kadipaten Malang.</p>
                        <p>Setelah itu, seiring bergulirnya waktu serta perpindahan dari zaman ke zaman, akhirnya di wilayah Jawa Timur muncul kerajan-kerajaan, antara lain : Kerajaan Doho Kediri, Singosari, yang mengembalikan Kadipaten Malang dari jajahan Mataram, Mojopahit, Demak dsb. Sampai dengan masuknya agama Islam ke tanah Jawa dengan pesat dan masuknya bangsa Eropa (bangsa Belanda) yang menjajah bumi nusantara.</p>
                        </div>
                        
                        <!-- Gradient Overlay for Collapsed State -->
                        <div x-show="!expanded" class="absolute bottom-0 left-0 right-0 h-40 bg-gradient-to-t from-surface-container-lowest via-surface-container-lowest/90 to-transparent pointer-events-none transition-opacity duration-300"></div>
                        </div>

                        <!-- Read More Button -->
                        <div class="mt-8 flex justify-center relative z-20">
                            <button @click="expanded = !expanded" class="group flex items-center gap-3 px-8 py-3.5 bg-surface-container-lowest hover:bg-primary/10 border-2 border-outline-variant/50 hover:border-primary/50 rounded-full font-label-lg font-bold text-on-surface-variant hover:text-primary transition-all duration-300 hover:shadow-lg hover:shadow-primary/10 hover:-translate-y-1">
                                <span x-text="expanded ? 'Tutup Detail' : 'Baca Selengkapnya'"></span>
                                <span class="material-symbols-outlined transition-transform duration-500" :class="expanded ? 'rotate-180' : ''">expand_more</span>
                            </button>
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
                                <img src="{{ asset('images/kadipaten.jpg') }}" alt="Era Kadipaten Malang" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Era Kadipaten Malang</h3>
                            <p class="font-body-md text-on-surface-variant text-lg text-justify">Dipimpin oleh Adipati Ronggo Tohjiwo, berpusat di Kuta Bedah, Buring. Wilayah ini dikenal sebagai Malang Kuso (Malang Eng-Kuso) berkat kemakmuran hasil taninya.</p>
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
                                <img src="{{ asset('images/mataram.jpg') }}" alt="Serangan Mataram" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Serangan Mataram</h3>
                            <p class="font-body-md text-on-surface-variant text-lg text-justify">Sultan Agung (Mataram) mengutus Patih Surontanu untuk menyerang Kadipaten Malang. Terjadilah peperangan sengit yang memporak-porandakan wilayah tersebut. Tumenggung Alap-alap membangun pertahanan.</p>
                        </div>
                    </div>

                    <!-- Timeline Item 3 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:text-right md:pr-16 pl-24 md:pl-0 order-2 md:order-1 mt-4 md:mt-0">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-3 aspect-video">
                                <img src="{{ asset('images/MangunDharma.jpg') }}" alt="Pelarian & Wafatnya Pahlawan" class="w-full h-full object-cover">
                            </div>
                            <p class="text-sm text-on-surface-variant italic mb-6 md:text-right">Mangun Yudho atau biasa dikenal Mangun Dharma</p>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Pelarian & Wafatnya Pahlawan</h3>
                            <p class="font-body-md text-on-surface-variant text-lg text-justify">Senopati Mangun Yudho terdesak dan melarikan diri, lalu dirawat oleh Mbok Rondo Kuning (asal nama Desa <strong>Tulusayu</strong>). Hingga akhirnya beliau moksa di Binangun, dan selimutnya dimakamkan di <strong>Kemulan</strong>.</p>
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
                                <img src="{{ asset('images/voc.jpg') }}" alt="Penguasaan VOC" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-primary mb-3">Penguasaan VOC</h3>
                            <p class="font-body-md text-on-surface-variant text-lg text-justify">Berdasarkan Perjanjian Mataram & VOC, wilayah Malang Timur diawasi VOC. Pembukaan lahan perkebunan tebu dan kopi dilakukan secara masif.</p>
                        </div>
                    </div>

                    <!-- Timeline Item 5 -->
                    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between group">
                        <div class="md:w-5/12 md:text-right md:pr-16 pl-24 md:pl-0 order-2 md:order-1 mt-4 md:mt-0">
                            <div class="rounded-3xl overflow-hidden shadow-lg mb-6 aspect-video">
                                <img src="{{ asset('images/balaidesa.png') }}" alt="Berdirinya Desa Tulusbesar" class="w-full h-full object-cover">
                            </div>
                            <h3 class="font-headline-md text-3xl font-bold text-secondary mb-3">Berdirinya Desa Tulusbesar</h3>
                            <p class="font-body-md text-on-surface-variant text-lg text-justify">Setelah Perang Jawa, Senopati Mangun Yudho diyakini oleh masyarakat sebagai tokoh yang melakukan <em>babat alas</em> dan menamakan daerah pemukiman baru ini dengan nama <strong>"Tulusbesar"</strong>.</p>
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
                <div class="text-center max-w-4xl mx-auto mb-16 relative z-10">
                    <span class="w-16 h-16 rounded-full bg-tertiary/10 text-tertiary flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-[32px]">auto_stories</span>
                    </span>
                    <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-6 tracking-tight">Sejarah Desa Versi Warga</h2>
                    <p class="font-body-md text-on-surface-variant text-xl">Cerita lisan dari para orang tua yang hingga kini dipercaya warga Desa Tulusbesar. Cerita tersebut menjadi sejarah yang selalu dituturkan dari orang dulu-dulu hingga anak cucunya sekarang.</p>
                </div>

                <div class="max-w-5xl mx-auto space-y-16 relative z-10">
                    <!-- Card 1 (Left) -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2.5rem] border border-outline-variant/30 shadow-sm p-8 md:p-12 flex flex-col md:flex-row gap-8 items-start hover:shadow-xl transition-all duration-500 relative overflow-hidden group">
                        <div class="absolute -right-32 -top-32 w-80 h-80 bg-primary/5 rounded-full blur-3xl group-hover:bg-primary/10 transition-colors duration-500"></div>
                        <div class="w-16 h-16 md:w-24 md:h-24 shrink-0 rounded-full bg-gradient-to-br from-primary/20 to-primary/5 text-primary flex items-center justify-center font-display-md text-3xl md:text-4xl font-black shadow-inner z-10 border border-primary/20">1</div>
                        <div class="z-10">
                            <h4 class="font-headline-sm text-3xl font-bold text-on-surface mb-6 group-hover:text-primary transition-colors">Mbah Mergo & Mbah Kerik</h4>
                            <div class="kti-format prose prose-lg prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed">
                                <p>Mbah Mergo memiliki nama asli Ronggo Wijoyo, beliau mempunya seorang cantrik atau anak buah yang bernama Pekik Ontokusumo atau yang biasa dipanggil Mbah Kerik. Sebutan Mbah Mergo kata "Mergo" yang berarti "karena" dianggap karena dengan adanya beliau sehingga ada Desa Tulusbesar. Mbah Kerik bertugas membersihkan di tempat hunian Mbah Mergo juga bertugas mendatangkan warga untuk berdomisili di Desa Tulusbesar.</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Card 2 (Right) -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2.5rem] border border-outline-variant/30 shadow-sm p-8 md:p-12 flex flex-col md:flex-row-reverse gap-8 items-start hover:shadow-xl transition-all duration-500 relative overflow-hidden group">
                        <div class="absolute -left-32 -top-32 w-80 h-80 bg-secondary/5 rounded-full blur-3xl group-hover:bg-secondary/10 transition-colors duration-500"></div>
                        <div class="w-16 h-16 md:w-24 md:h-24 shrink-0 rounded-full bg-gradient-to-br from-secondary/20 to-secondary/5 text-secondary flex items-center justify-center font-display-md text-3xl md:text-4xl font-black shadow-inner z-10 border border-secondary/20">2</div>
                        <div class="z-10 md:text-right">
                            <h4 class="font-headline-sm text-3xl font-bold text-on-surface mb-6 group-hover:text-secondary transition-colors">Mbah Ingsun, Mbah Latif & Gua Klinting</h4>
                            <div class="kti-format prose prose-lg prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed ml-auto">
                                <p>Konon yang babad alas di Dusun Sumbersari adalah Mbah Ingsun dan yang bedah kerawang adalah Mbah Latif. Makam Mbah Ingsun tidak diketahui. Makam Mbah Latif ditemukan di area pekarangan milik warga tepat di pinggir jalan raya. Makam ini berada di bawah pohon pole di sekitarnya tumbuh rimbunan pohon bambu.</p>
                                <p>Mbaran Tulusayu diresmikan jadi Dusun Sumbersari karena asal mulanya ada sebuah sumber di urug-urug tengah Gua Klinting. Joko Klinting sebagai penunggu atau danyang di gua tersebut dengan tanda pohon kemuning di sebelah kiri mulut gua. Pedanyangan di sana bukanlah pohon beringin tapi pohon pole dan kayu bulu sebagai tempat sadranan. Apabila ada orang yang mempunyai hajat memberikan sedekah berupa soh atau cok bakal. Artinya memberikan bakalan yang berupa sesajian. Namun secara administrasi Gua Klinting masuk wilayah Desa Tumpang. Dan air dari sumber Gua Klinting mengalir ke bawah menuju Desa Pulungdowo. Warga Desa Pulungdowo menggunakan air tersebut untuk keperluan sehari-hari.</p>
                                <p>Pada tahun 1982 pohon tersebut dipotong karena perbuatan memberikan sesajian itu dianggap syirik dan tak ada lagi kegiatan adat itu. Pada tahun 2013 Bapak Kepala Dusun menyatukan tokoh agama dan tokoh adat untuk mengadakan pengajian di Makam Mbah Latif. Warga merawatnya sebagai punden pahlawan desa. Hingga sekarang setiap hari Jumat Legi dilakukan pembacaan Istiqosah dan Tahlil.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 (Left) -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2.5rem] border border-outline-variant/30 shadow-sm p-8 md:p-12 flex flex-col md:flex-row gap-8 items-start hover:shadow-xl transition-all duration-500 relative overflow-hidden group">
                        <div class="absolute -right-32 -bottom-32 w-80 h-80 bg-tertiary/5 rounded-full blur-3xl group-hover:bg-tertiary/10 transition-colors duration-500"></div>
                        <div class="w-16 h-16 md:w-24 md:h-24 shrink-0 rounded-full bg-gradient-to-br from-tertiary/20 to-tertiary/5 text-tertiary flex items-center justify-center font-display-md text-3xl md:text-4xl font-black shadow-inner z-10 border border-tertiary/20">3</div>
                        <div class="z-10">
                            <h4 class="font-headline-sm text-3xl font-bold text-on-surface mb-6 group-hover:text-tertiary transition-colors">Mbah Kimar & Mbok Rondo Kuning</h4>
                            <div class="kti-format prose prose-lg prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed">
                                <p>Di sebelah selatan makam Mbok Rondo Kuning dulu ditemukan makam Mbah Kimar. Beberapa warga Dusun Prapatan mengetahui hal tersebut. Kemungkinan makamnya hanya ditandai dengan tumpukan batu, pondasi atau ditanami pohon. Seiring berjalannya waktu makam itu telah tiada. Kemungkinan karena makam tersebut berada di area perkebunan yang tak terawat lambat-laun tertutup oleh rumput-rumput dan warga tidak memberitahu atau tidak menceritakan pada generasi penerusnya sehingga makam Mbah Kimar hilang. Sebagian warga yang masih percaya jika kirim doa tak lupa mendoakan Mbah Kimar walau nyekar dilakukan di makam Mbok Rondo Kuning.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 (Right) -->
                    <div class="bg-surface-container-lowest/90 backdrop-blur-sm rounded-[2.5rem] border border-outline-variant/30 shadow-sm p-8 md:p-12 flex flex-col md:flex-row-reverse gap-8 items-start hover:shadow-xl transition-all duration-500 relative overflow-hidden group">
                        <div class="absolute -left-32 -bottom-32 w-80 h-80 bg-orange-500/5 rounded-full blur-3xl group-hover:bg-orange-500/10 transition-colors duration-500"></div>
                        <div class="w-16 h-16 md:w-24 md:h-24 shrink-0 rounded-full bg-gradient-to-br from-orange-500/20 to-orange-500/5 text-orange-500 flex items-center justify-center font-display-md text-3xl md:text-4xl font-black shadow-inner z-10 border border-orange-500/20">4</div>
                        <div class="z-10 md:text-right">
                            <h4 class="font-headline-sm text-3xl font-bold text-on-surface mb-6 group-hover:text-orange-500 transition-colors">Mbah Talpuk & Peninggalan VOC</h4>
                            <div class="kti-format prose prose-lg prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed ml-auto">
                                <p>Makam Mbah Talpuk terletak di area pedanyangan Krajan kulon. Ada yang mengatakan beliau adalah anak Mbah Mergo atau Mbah Kerik, juga masih saudara Mbah Srimunah. Dulu warga Tulusbesar mengadakan nyadranan dan barikan di sana. Pada tahun 1980-an pohon beringin ditebang tradisi adat setempat hilang. Di area pedanyangan Krajan kulon status kepemilikan tanah adalah milik pribadi seseorang, pemilik menjual tanahnya dengan cara dikavling.</p>
                                <p>Ada sebuah gundukan atau gumuk yang diratakan lalu diukur per-petak kavling. Di situ ditemukan bongkahan bekas bangunan berupa pondasi batu bata merah yang besar-besar dan juga batu besar. Ukuran batu bata merah itu sama dengan 6x ukuran batu bata merah pada umumnya yang sekarang. Selain itu disekitar sana juga ditemukan uang koin bertuliskan VOC. Diperkirakan batu bata dan uang koin itu adalah peninggalan zaman Belanda.</p>
                                <p>Bangunan tersebut diyakini adalah makam Mbah Talpuk. Warga sekitar ada yang mempercayai hal itu dan ada pula yang tidak. Area pedanyangan itu kini telah menjadi deretan rumah-rumah warga. Saat warga telah membeli tanah kavling lalu hendak membangunnya, peninggalan sejarah yang ditemukan di sana seperti batu bata merah dan batu yang besar telah dipindahkan. Hanya sebagian kecil warga saja yang masih menyimpan di rumahnya. Secara administrasi wilayah tersebut masuk Dusun Jago Desa Tumpang.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 4: Awal Terbentuknya Desa Tulusbesar -->
            <section id="zaman-belanda">
                <div class="bg-surface-container/90 backdrop-blur-md border border-outline-variant/30 p-8 md:p-16 rounded-[4rem] shadow-sm relative overflow-hidden block">
                    <!-- Decorative Elements -->
                    <div class="absolute -right-32 -bottom-32 w-96 h-96 bg-secondary/10 rounded-full blur-3xl"></div>
                    
                    <div class="relative z-10 w-full">
                        <div class="float-none lg:float-left w-full lg:w-5/12 lg:mr-12 mb-8 relative z-10" style="text-align: center; padding-top: 1rem; padding-bottom: 2rem;">
                            <img src="{{ asset('images/gapura.jpg') }}" alt="Gapura Desa Tulusbesar" style="width: 100%; max-width: 350px; height: 460px; object-fit: cover; border-radius: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25); transform: rotate(2deg); filter: sepia(0.3) contrast(1.25); display: inline-block; background-color: #e5e7eb; margin-bottom: 1.5rem;">
                            <p class="text-sm md:text-base text-center text-on-surface-variant font-medium italic rotate-2 px-6">
                                "Foto gapura masuk Desa Tulusbesar dari Dusun Ronggowuni pada masa kepemimpinan Bapak Supeno"
                            </p>
                        </div>

                        <span class="font-label-md text-secondary tracking-widest uppercase mb-4 block font-bold mt-4 lg:mt-0">Awal Terbentuknya</span>
                        <h2 class="font-display-md text-4xl md:text-5xl font-black text-on-surface mb-8 tracking-tight">Terbentuknya Desa Tulusbesar</h2>
                        
                        <div class="kti-format prose prose-lg md:prose-xl prose-p:text-on-surface-variant prose-p:text-justify prose-p:leading-relaxed max-w-none">
                            <p>Cerita para orang tua atau keterangan dari para sesepuh desa dan Kitab Babad Malang, kata <strong>Mbesar</strong> adalah <em>Mbes</em> atau sumber air yang besar-besar. Karena banyaknya Mbes sehingga menjadi anak sungai yang namanya Kali Lanang. Pertemuan Kali Lanang dan sungai dari Sumber Pitu yang dianggap sebagai Kali Wedok di Tulusbesar ada kisaran mahnitis air spiritual yang bernama banyu tempur atau air suci.</p>
                            <p>Di mana dahulu para ilmuwan, Padepokan Seni Mangir, Padepokan Seni Tulusayu, Padhepokan Mangun Dharmo jika ada pembaiyatan pembelajaran dalang, penari, tandak, selalu dimandikan di sana supaya partikel tubuhnya di-nol-kan. Pada jam 12 malam tepat. Setelah itu dilunturkan dengan kelor dan air cucian beras atau leri. Supaya mereka yang memiliki kekebalan bisa luntur. Menurut leluhur jika orang belajar budaya tidak boleh memiliki ilmu kanuragan. Dari sinilah nama asal Desa Mbesar yang diambil dari kata Mbes, karena di daerah ini ada banyak Mbes yang besar-besar. Kata <strong>Tulus</strong> juga mengandung maksud warga masyarakat dengan tulus untuk merawat kelestarian sumber-sumber dan ekosistem alam karena air itu berguna untuk kesuburan pertanian.</p>
                            <p>Pada saat penjajahan Belanda kekuasaan kerajaan tentu berangsur-angsur hilang dan berubah menjadi kelompok-kelompok daerah kekuasaan, antara lain dengan adanya Desa, Kecamatan, Kadipaten, Kresidenan dan Gubernuran yang kesemuanya di bawah kekuasan dan komando langsung dari bangsa Belanda yang berkedudukan di Batavia.</p>
                            <p>Pada awalnya Desa Tulusbesar terdiri dari 2 desa, yaitu <strong>Desa Tulusayu</strong> (yang terdiri dari 3 pedukuhan, yakni Tulusayu Prapatan, Kemulan dan Baran Tulusayu/Baran Sumbersari) dan <strong>Desa Mbesar</strong> (yang terdiri dari 2 pedukuhan, yakni Mbesar Kulon dan Mbesar Wetan). Kedua desa ini masing-masing dipimpin oleh seorang Kepala Desa dengan istilah Petinggi, yang diangkat oleh Belanda, silih berganti selama penjajahan Belanda.</p>
                            <p>Kemudian pada tahun 1870, mengingat Desa Tulusayu jumlah penduduk dan wilayahnya kecil, maka Pemerintah Belanda berkeinginan menggabungkan Desa Tulusayu tersebut kepada desa lain yang terdekat, ada dua pilihan, yaitu digabung dengan Desa Mbesar atau Desa Belung. Namun ternyata setelah diadakan undian, Desa Tulusayu akhirnya digabung dengan Desa Mbesar, maka jadilah Desa Tulusbesar yang status administratifnya masuk dalam wilayah Kecamatan Tumpang. Dengan adanya penggabungan desa tersebut maka Desa Tulusbesar terdiri dari 5 pedukuhan (Besar Kulon/Besar Barat, Besar Wetan/Besar Timur, Kemulan, Tulusayu Prapatan dan Baran Tulusayu).</p>
                            
                            <h3 class="font-headline-md text-2xl font-bold text-on-surface mt-12 mb-6 flex items-center gap-3 clear-both pt-8">
                                <span class="material-symbols-outlined text-secondary">history_edu</span>
                                Tantangan Pembangunan Masa Lampau
                            </h3>
                            <p>Dari waktu ke waktu Desa Tulusbesar mengalami pergantian kepemimpinan atau Kepala Desa (Petinggi), ada yang asli putra daerah Desa Tulusbesar hasil pemilihan dan ada yang dari luar desa (merupakan pejabat sementara/Karteker), akibatnya pembangunan Desa Tulusbesar pada masa lampau dapat dikatakan lamban. Pada prinsipnya setiap pejabat atau pemimpin Desa Tulusbesar terdahulu mempunyai satu tujuan yang mulia, yakni ingin membangun dan memajukan desanya, akan tetapi karena situasi dan kondisi zaman pada waktu itu tidak mendukung menyebabkan pembangunan berjalan kurang kondusif. Banyak faktor penghambat pembangunan di desa ini, antara lain disebabkan oleh:</p>
                            
                            <div class="grid grid-cols-1 gap-4 mt-8 not-prose">
                                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/50 shadow-sm flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-error/10 text-error flex items-center justify-center shrink-0 mt-1">
                                        <span class="material-symbols-outlined">gavel</span>
                                    </div>
                                    <p class="font-body-md text-on-surface-variant text-justify">Kepala Desa atau Petinggi pada zaman Penjajahan Belanda hanya berperan sebagai <strong class="text-on-surface">boneka penguasa</strong> saja tanpa kewenangan mandiri.</p>
                                </div>
                                
                                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/50 shadow-sm flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-orange-500/10 text-orange-500 flex items-center justify-center shrink-0 mt-1">
                                        <span class="material-symbols-outlined">warning</span>
                                    </div>
                                    <p class="font-body-md text-on-surface-variant text-justify">Pasca perang kemerdekaan (revolusi fisik), kondisi masyarakat secara umum <strong class="text-on-surface">masih trauma</strong> akibat perang, ditambah belum adanya aturan pemerintahan yang pasti.</p>
                                </div>

                                <div class="bg-surface-container-lowest rounded-2xl p-6 border border-outline-variant/50 shadow-sm flex gap-4 items-start">
                                    <div class="w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center shrink-0 mt-1">
                                        <span class="material-symbols-outlined">policy</span>
                                    </div>
                                    <p class="font-body-md text-on-surface-variant text-justify">Setelah peristiwa G30S/PKI, stabilitas terganggu. Pejabat sementara (karteker) hanya fokus pada <strong class="text-on-surface">pemulihan keadaan dan keamanan</strong> dari gangguan politik (SARA) dengan waktu menjabat yang relatif singkat.</p>
                                </div>
                            </div>
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
                                        <img src="{{ asset('images/ImageKades/default.svg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Bapak Noni, Temah, Mini
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-surface-variant rounded-lg text-sm">Petinggi Desa</span></td>
                                </tr>
                                <!-- 1951 -->
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1951 – 1963</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/default.svg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Abdul Razak Rekso Dihardjo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1964 – 1965</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/default.svg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Tawi
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1966 – 1969</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/default.svg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Karto Prawiro Kirun
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1970 – 1971</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/wasis.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Wasis
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">1972 – 1973</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/default.svg') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Mochamad Winardi
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-tertiary/10 text-tertiary rounded-lg text-sm font-bold">Karteker (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1973 – Mar 1975</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/Supeno.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Supeno Niti Mangun Kusumo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Apr 1975 – Sep 1975</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/asan.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Asan Rachmad
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-sm font-bold">Pjs (Ditunjuk)</span></td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1975 – Apr 1989</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/kasnawi.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Kasnawi Noto Karyo Wibowo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Mei 1989 – Sep 1998</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/Sarkam.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Sarkam Rekso Mangku Wibowo
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Okt 1998 – Mar 2013</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/setyo.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Setyo Adi, S.Pd.
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Apr 2013 – Jul 2019</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/Sri.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Sri Widarti, S.Pd
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Agt 2019 – Nov 2021</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/Hudi.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Hudi Mariono
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant">Kepala Desa (Pemilihan)</td>
                                </tr>
                                <tr class="hover:bg-surface-variant/30 transition-colors">
                                    <td class="px-8 py-5 font-label-lg text-on-surface whitespace-nowrap">Des 2021 – Nov 2022</td>
                                    <td class="px-8 py-5 font-body-lg text-on-surface-variant font-bold flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/Lailia.png') }}" class="w-10 h-10 rounded-full object-cover border border-outline-variant" alt="">
                                        Lailia Kurniawati, ST., MM
                                    </td>
                                    <td class="px-8 py-5 font-body-md text-on-surface-variant"><span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-lg text-sm font-bold">Pj Kepala Desa (Ditunjuk)</span></td>
                                </tr>
                                <tr class="bg-primary/5 hover:bg-primary/10 transition-colors">
                                    <td class="px-8 py-6 font-label-xl text-primary whitespace-nowrap">Des 2022 – Sekarang</td>
                                    <td class="px-8 py-6 font-display-sm text-primary font-black flex items-center gap-3">
                                        <img src="{{ asset('images/ImageKades/SiratYudin.png') }}" class="w-12 h-12 rounded-full object-cover border-2 border-primary shadow-sm" alt="">
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
                        <div class="kti-format prose prose-xl prose-p:text-on-tertiary-container/90 prose-p:text-justify prose-p:leading-relaxed">
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
                                <img src="{{ asset('images/ImageKades/SiratYudin.png') }}" alt="Bapak Sirat Yudin" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section 7: Foto Kegiatan Desa -->
            @if(isset($activities) && $activities->count() > 0)
            <section id="kegiatan-desa" class="mt-24">
                <div class="text-center mb-16 relative">
                    <div class="absolute left-1/2 -top-12 -ml-0.5 w-1 h-12 bg-outline-variant"></div>
                    <h2 class="font-display-md text-3xl md:text-4xl font-black tracking-tight uppercase">FOTO-FOTO KEGIATAN DESA <br> 
                </h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border-t-2 border-l-2 border-primary/30 max-w-5xl mx-auto bg-surface-container-lowest">
                    @foreach($activities as $activity)
                    <div class="border-b-2 border-r-2 border-primary/30 p-4 md:p-8 flex flex-col group hover:bg-primary/5 transition-colors">
                        <div class="aspect-[4/3] overflow-hidden rounded-xl shadow-md mb-6 relative">
                            <img src="{{ asset('storage/' . $activity->image_path) }}" alt="Kegiatan Desa" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        </div>
                        @if($activity->description)
                        <div class="text-center flex-grow flex items-center justify-center px-4">
                            <p class="font-body-lg text-primary text-lg md:text-xl">{{ $activity->description }}</p>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </section>
            @endif

        </div>

        <x-footer />
    </div>
</div>
@endsection
