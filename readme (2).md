# 🌾 Sistem Informasi & WebGIS Desa Tulusbesar

Sistem Informasi dan Website Profil Desa terintegrasi yang dibangun untuk mendigitalkan layanan informasi, dokumentasi kegiatan, dan pelestarian kearifan lokal di Desa Tulusbesar. Proyek ini merupakan luaran dari program Kuliah Kerja Nyata (KKN) dan dikembangkan dengan pendekatan desain **"Javanese Earthy"** yang memadukan teknologi tata kelola cerdas (*Smart Governance*) dengan nilai-nilai luhur budaya lokal.

## 👥 Tim Pengembang
Proyek ini dikembangkan menggunakan arsitektur **Multi-Panel CMS**, dengan pembagian tugas sebagai berikut:
*   **Rakagali (Rageel)** - *Lead Developer* 
    * Mengembangkan *UI/UX* Portal Publik (Beranda, Profil, Inovasi, Kearifan Lokal).
    * Mengelola integrasi CMS (Filament) untuk konten publik dan katalog wisata (Smart QR).
*   **Rekan Developer** - *WebGIS & Admin Developer* 
    * Mengembangkan Modul WebGIS interaktif.
    * Mengelola panel administrasi internal desa dan pemetaan titik koordinat infrastruktur.

## 🚀 Teknologi Pendukung (TALL Stack)
Repositori ini telah diinisiasi dengan ekosistem berikut:
*   **Framework:** Laravel 11 (PHP)
*   **Frontend:** Tailwind CSS (dengan *custom design tokens*), Alpine.js, Blade Templates
*   **Backend CMS:** Filament PHP v3
*   **Database:** MySQL (Bisa disesuaikan ke PostgreSQL)
*   **Local Environment:** Laragon

## 🗄️ Arsitektur & Skema Database
Sistem ini menggunakan struktur database berbasis Eloquent ORM. Berikut adalah rancangan tabel utama yang digunakan dalam pengembangan:

1.  **`village_profiles` (Tabel Singleton)**
    *   Menyimpan data statis desa: `visi` (text), `misi` (text), `sejarah` (text), `total_population` (integer), `area_size` (integer).
2.  **`cultural_sites` (Kearifan Lokal & Pariwisata)**
    *   Katalog wisata dan budaya: `name` (string), `slug` (string), `description` (text), `latitude` & `longitude` (decimal), `image_path` (string), `status` (enum). Diintegrasikan dengan fitur Smart QR.
3.  **`gis_features` (Data Spasial WebGIS)**
    *   Titik koordinat pemetaan desa: `name` (string), `category` (PJU, Sampah, Peternakan, Fasilitas Umum), `description` (text), `latitude` & `longitude` (decimal).
4.  **`news_articles` (Publikasi & Berita)**
    *   Repositori kegiatan desa: `title` (string), `slug` (string), `content` (longText), `image_path` (string), `published_at` (datetime).
5.  **`village_documents` (Arsip Publik)**
    *   Manajemen regulasi/file unduhan: `title` (string), `description` (text), `file_path` (string).