<?php

use App\Models\Berita;
use App\Models\CulturalSite;
use App\Models\FotoKegiatan;
use App\Models\PerangkatDesa;
use App\Models\ProfilDesa;
use App\Models\Surat;
use App\Models\Umkm;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage
Route::get('/', function () {
    $beritaTerbaru = Berita::where('status', 'published')->latest('tanggal_publish')->take(3)->get();
    $fotoKegiatan = FotoKegiatan::where('status', 'active')->latest()->take(6)->get();
    $profilDesa = ProfilDesa::first();
    $perangkatDesa = PerangkatDesa::where('status', 'active')->orderBy('urutan')->get();

    return view('welcome', compact('beritaTerbaru', 'fotoKegiatan', 'profilDesa', 'perangkatDesa'));
})->name('home');

// Profil Desa
Route::get('/profil-desa', function () {
    $profil = ProfilDesa::first();

    return view('pages.profil', compact('profil'));
})->name('profil');

// Berita
Route::get('/berita', function () {
    $beritas = Berita::where('status', 'published')->latest('tanggal_publish')->paginate(9);

    return view('pages.berita-index', compact('beritas'));
})->name('berita.index');

Route::get('/berita/{slug}', function ($slug) {
    $berita = Berita::where('slug', $slug)->where('status', 'published')->firstOrFail();
    $beritaLainnya = Berita::where('id', '!=', $berita->id)->where('status', 'published')->latest('tanggal_publish')->take(3)->get();

    return view('pages.berita-show', compact('berita', 'beritaLainnya'));
})->name('berita.show');

// UMKM
Route::get('/umkm', function () {
    $umkms = Umkm::where('status', 'active')->latest()->paginate(9);

    return view('pages.umkm-index', compact('umkms'));
})->name('umkm.index');

Route::get('/umkm/{slug}', function ($slug) {
    $umkm = Umkm::where('slug', $slug)->where('status', 'active')->firstOrFail();
    $umkmLainnya = Umkm::where('id', '!=', $umkm->id)->where('status', 'active')->latest()->take(3)->get();

    return view('pages.umkm-show', compact('umkm', 'umkmLainnya'));
})->name('umkm.show');

// WebGIS / Peta Desa
Route::get('/peta', function () {
    return view('pages.peta');
})->name('peta');

// Perangkat Desa
Route::get('/perangkat-desa', function () {
    $perangkats = PerangkatDesa::where('status', 'active')->orderBy('urutan')->get();

    return view('pages.perangkat-desa', compact('perangkats'));
})->name('perangkat');

// Wisata & Budaya
Route::get('/wisata', function () {
    $wisatas = CulturalSite::where('status', 'active')->latest()->paginate(9);

    return view('pages.wisata-index', compact('wisatas'));
})->name('wisata.index');

Route::get('/wisata/{slug}', function ($slug) {
    $wisata = CulturalSite::where('slug', $slug)->firstOrFail();
    $recommendations = CulturalSite::where('id', '!=', $wisata->id)->where('status', 'active')->latest()->take(4)->get();

    return view('pages.wisata-show', compact('wisata', 'recommendations'));
})->name('wisata.show');

/**
 * Route untuk serve Preview PDF secara langsung dengan Content-Type: application/pdf
 */
Route::get('/surat/preview-pdf/{sessionId?}', function (?string $sessionId = null) {
    if (! $sessionId) {
        abort(404, 'Preview PDF belum tersedia.');
    }

    $cleanSessionId = preg_replace('/[^a-zA-Z0-9]/', '_', $sessionId);
    $path = storage_path('app/public/temp-preview/preview_' . $cleanSessionId . '.pdf');

    if (! file_exists($path)) {
        abort(404, 'Preview PDF belum tersedia.');
    }

    return response()->file($path, [
        'Content-Type'        => 'application/pdf',
        'Content-Disposition' => 'inline; filename="preview.pdf"',
    ]);
})->name('surat.preview-pdf');
