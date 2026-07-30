<?php

use App\Models\CulturalSite;
use App\Models\NewsArticle;
use App\Models\Umkm;
use App\Models\VillageHistory;
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

    return view('pages.home', compact('news', 'umkms', 'profile', 'allImages'));
})->name('home');

Route::get('/profil', function () {
    $profile = VillageProfile::first();
    $histories = VillageHistory::orderBy('order_sequence')->orderBy('year')->get();

    return view('pages.profil', compact('profile', 'histories'));
})->name('profil');

Route::get('/wisata', function () {
    $sites = CulturalSite::where('status', 'active')->latest()->get();

    return view('pages.wisata', compact('sites'));
})->name('wisata');

Route::get('/peta', function () {
    $features = \App\Models\GisFeature::all();
    return view('pages.peta', compact('features'));
})->name('peta');

Route::get('/publikasi', function () {
    $news = NewsArticle::latest('published_at')->get();

    return view('pages.publikasi', compact('news'));
})->name('publikasi');

Route::get('/umkm', function () {
    $umkms = Umkm::latest()->get();

    return view('pages.umkm', compact('umkms'));
})->name('umkm');

Route::get('/berita/{slug}', function ($slug) {
    $berita = NewsArticle::where('slug', $slug)->firstOrFail();

    return view('pages.berita-show', compact('berita'));
})->name('berita.show');

Route::get('/umkm/{slug}', function ($slug) {
    $umkm = Umkm::where('slug', $slug)->firstOrFail();

    return view('pages.umkm-show', compact('umkm'));
})->name('umkm.show');

Route::get('/wisata/{slug}', function ($slug) {
    $wisata = CulturalSite::where('slug', $slug)->firstOrFail();

    return view('pages.wisata-show', compact('wisata'));
})->name('wisata.show');
