<?php

use App\Models\CulturalSite;
use App\Models\GisFeature;
use App\Models\NewsArticle;
use App\Models\Umkm;
use App\Models\VillageOfficial;
use App\Models\VillageProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $news = NewsArticle::latest('published_at')->take(3)->get();
    $umkms = Umkm::latest()->take(3)->get();
    $profile = VillageProfile::first();

    // Kumpulkan semua gambar dari semua konten untuk slideshow
    $allImages = collect()
        ->merge(
            NewsArticle::whereNotNull('image_path')->latest('published_at')->get()
                ->map(fn ($n) => asset('storage/'.$n->image_path))
        )
        ->merge(
            Umkm::whereNotNull('image_path')->latest()->get()
                ->map(fn ($u) => asset('storage/'.$u->image_path))
        )
        ->merge(
            CulturalSite::whereNotNull('image_path')->where('status', 'active')->latest()->get()
                ->map(fn ($s) => asset('storage/'.$s->image_path))
        )
        ->values()
        ->toArray();

    if (empty($allImages)) {
        $allImages = [asset('images/dummy/profil.jpg')];
    }

    $officials = VillageOfficial::orderBy('order')->get();

    return view('pages.home', compact('news', 'umkms', 'profile', 'allImages', 'officials'));
})->name('home');

Route::get('/wisata', function () {
    $sites = CulturalSite::where('status', 'active')->latest()->get();

    return view('pages.wisata', compact('sites'));
})->name('wisata');

Route::get('/sejarah', function () {
    $activities = \App\Models\ActivityPhoto::latest()->get();
    return view('pages.sejarah', compact('activities'));
})->name('sejarah');

Route::get('/peta', function () {
    $features = GisFeature::all();
    $culturalSites = CulturalSite::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->where('status', 'active')
        ->get();
        
    $umkms = Umkm::whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->get();

    return view('pages.peta', compact('features', 'culturalSites', 'umkms'));
})->name('peta');

Route::get('/publikasi', function () {
    $news = NewsArticle::latest('published_at')->paginate(8);

    return view('pages.publikasi', compact('news'));
})->name('publikasi');

Route::get('/umkm', function () {
    $umkms = Umkm::latest()->get();

    return view('pages.umkm', compact('umkms'));
})->name('umkm');

Route::get('/berita/{slug}', function ($slug) {
    $berita = NewsArticle::where('slug', $slug)->firstOrFail();
    $recommendations = NewsArticle::where('id', '!=', $berita->id)->latest('published_at')->take(4)->get();

    return view('pages.berita-show', compact('berita', 'recommendations'));
})->name('berita.show');

Route::get('/umkm/{slug}', function ($slug) {
    $umkm = Umkm::where('slug', $slug)->firstOrFail();
    $recommendations = Umkm::where('id', '!=', $umkm->id)->latest()->take(4)->get();

    return view('pages.umkm-show', compact('umkm', 'recommendations'));
})->name('umkm.show');

Route::get('/wisata/{slug}', function ($slug) {
    $wisata = CulturalSite::where('slug', $slug)->firstOrFail();
    $recommendations = CulturalSite::where('id', '!=', $wisata->id)->where('status', 'active')->latest()->take(4)->get();

    return view('pages.wisata-show', compact('wisata', 'recommendations'));
})->name('wisata.show');
