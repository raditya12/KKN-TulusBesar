<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VillageProfile;
use App\Models\Umkm;
use App\Models\CulturalSite;
use App\Models\NewsArticle;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Village Profile
        VillageProfile::create([
            'visi' => 'Terwujudnya Desa Tulusbesar yang Mandiri, Sejahtera, dan Berbudaya.',
            'misi' => 'Meningkatkan ekonomi kerakyatan melalui UMKM dan pelestarian sejarah.',
            'sejarah' => 'Desa Tulusbesar memiliki sejarah panjang sejak era Kerajaan Singasari...',
            'total_population' => 6140,
            'area_size' => 460,
        ]);



        // 3. Cultural Sites (Wisata)
        CulturalSite::create([
            'name' => 'Pesarean Senopati Mangun Yudho',
            'slug' => 'pesarean-senopati-mangun-yudho',
            'description' => 'Makam ulama dan tokoh pejuang pengikut setia Pangeran Diponegoro yang menjadi leluhur Desa Tulusbesar.',
            'image_path' => 'images/dummy/wisata1.jpg', // dummy text fallback
        ]);
        CulturalSite::create([
            'name' => 'Petilasan Mbah Ageng Macan Putih',
            'slug' => 'petilasan-mbah-ageng-macan-putih',
            'description' => 'Situs keramat yang dipercaya sebagai tempat pertapaan tokoh spiritual pendiri desa.',
            'image_path' => 'images/dummy/wisata2.jpg',
        ]);
        CulturalSite::create([
            'name' => 'Seni Tari Topeng Malangan',
            'slug' => 'tari-topeng-malangan',
            'description' => 'Paguyuban kesenian tari topeng khas Malang yang lestari.',
            'image_path' => 'images/dummy/tradisi3.jpg',
        ]);
        CulturalSite::create([
            'name' => 'Kesenian Bantengan (Mberot)',
            'slug' => 'bantengan',
            'description' => 'Kesenian pertunjukan rakyat yang menggabungkan unsur tari, pencak silat, dan magis.',
            'image_path' => 'images/dummy/tradisi1.jpg',
        ]);

        // 4. UMKMs
        $umkms = [
            ['name' => 'Sentra Tahu Tulusbesar', 'slug' => 'sentra-tahu', 'category' => 'Kuliner & Pangan', 'desc' => 'Desa Tulusbesar adalah lumbung utama produksi tahu kualitas premium.', 'img' => 'images/dummy/umkm1.jpg'],
            ['name' => 'Topeng Kayu Malangan', 'slug' => 'topeng-kayu', 'category' => 'Kriya & Seni', 'desc' => 'Kerajinan ukir topeng kayu berkarakter tokoh pewayangan khas Malangan.', 'img' => 'images/dummy/tradisi3.jpg'],
            ['name' => 'Kerajinan Bubut Gerabah', 'slug' => 'bubut-gerabah', 'category' => 'Kriya', 'desc' => 'Home industri pembuatan dan pembubutan gerabah berbahan tanah liat lokal.', 'img' => 'images/dummy/wisata3.jpg'],
            ['name' => 'Anyaman & Kursi Bambu', 'slug' => 'anyaman-bambu', 'category' => 'Perabotan', 'desc' => 'Pemanfaatan bambu dari sekitar desa untuk dirajut menjadi produk anyaman.', 'img' => 'images/dummy/tradisi2.jpg'],
            ['name' => 'Produksi Syal & Batu Merah', 'slug' => 'syal-batu-merah', 'category' => 'Kriya', 'desc' => 'Kreativitas tekstil syal rajut tangan, serta sentra pembuatan bata.', 'img' => 'images/dummy/wisata1.jpg'],
            ['name' => 'Peternakan Madu Tawon', 'slug' => 'madu-tawon', 'category' => 'Agro & Peternakan', 'desc' => 'Peternakan lebah madu mandiri yang memanfaatkan nektar ekosistem.', 'img' => 'images/dummy/wisata2.jpg'],
            ['name' => 'Budi Daya Puyuh & Jamur', 'slug' => 'puyuh-jamur', 'category' => 'Agroindustri', 'desc' => 'Budidaya jamur tiram organik dan peternakan burung puyuh.', 'img' => 'images/dummy/tradisi1.jpg'],
            ['name' => 'Nata de Coco & Permen', 'slug' => 'nata-de-coco', 'category' => 'Jajanan', 'desc' => 'Produksi sari kelapa dan permen olahan tradisional.', 'img' => 'images/dummy/hero.jpg'],
            ['name' => 'Telur Asin & Gerit Jagung', 'slug' => 'telur-asin', 'category' => 'Pangan Lokal', 'desc' => 'Pembuatan telur asin khas dengan tingkat masir yang pas.', 'img' => 'images/dummy/profil.jpg'],
        ];
        foreach ($umkms as $u) {
            Umkm::create([
                'name' => $u['name'],
                'slug' => $u['slug'],
                'category' => $u['category'],
                'description' => $u['desc'],
                'image_path' => $u['img'],
            ]);
        }

        // 5. News Articles
        NewsArticle::create([
            'title' => 'Peresmian Balai Desa Baru',
            'slug' => 'peresmian-balai-desa',
            'content' => '<p>Acara peresmian balai desa dihadiri oleh Bupati Malang.</p>',
            'published_at' => now(),
            'image_path' => 'images/dummy/hero.jpg',
        ]);
        NewsArticle::create([
            'title' => 'Pelatihan Digitalisasi UMKM',
            'slug' => 'pelatihan-digitalisasi',
            'content' => '<p>Mahasiswa KKN mengadakan pelatihan digital marketing untuk pelaku UMKM lokal.</p>',
            'published_at' => now()->subDays(2),
            'image_path' => 'images/dummy/umkm1.jpg',
        ]);
        NewsArticle::create([
            'title' => 'Festival Budaya Bantengan',
            'slug' => 'festival-bantengan',
            'content' => '<p>Festival tahunan ini menarik ribuan pengunjung dari seluruh penjuru daerah.</p>',
            'published_at' => now()->subDays(5),
            'image_path' => 'images/dummy/tradisi1.jpg',
        ]);
    }
}
