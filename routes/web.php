<?php

use App\Http\Controllers\LocationSiteController;
use App\Models\LocationSite;
use App\Models\NewsArticle;
use App\Models\VillageHistory;
use App\Models\VillageProfile;
use App\Models\VillageOfficial;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $news = NewsArticle::latest('published_at')->take(3)->get();
    $umkms = LocationSite::where('category', 'UMKM')->where('status', 'active')->latest()->take(3)->get();
    $profile = VillageProfile::first();

    // Kumpulkan semua gambar dari semua konten untuk slideshow
    $allImages = collect()
        ->merge(
            NewsArticle::whereNotNull('image_path')->latest('published_at')->get()
                ->map(fn ($n) => asset('storage/'.$n->image_path))
        )
        ->merge(
            LocationSite::whereNotNull('image_path')->where('status', 'active')->latest()->get()
                ->map(fn ($s) => asset('storage/'.$s->image_path))
        )
        ->values()
        ->toArray();

    if (empty($allImages)) {
        $allImages = [asset('images/dummy/profil.jpg')];
    }

    $histories = VillageHistory::orderBy('order_sequence')->orderBy('year')->get();
    $officials = VillageOfficial::orderBy('order')->get();

    return view('pages.home', compact('news', 'umkms', 'profile', 'allImages', 'histories', 'officials'));
})->name('home');

Route::get('/wisata', function () {
    $sites = LocationSite::where('category', 'Situs Budaya')->where('status', 'active')->latest()->get();

    return view('pages.wisata', compact('sites'));
})->name('wisata');

Route::get('/peta', function () {
    $features = LocationSite::with('locationCategory')->where('status', 'active')->get();
    $categories = \App\Models\LocationCategory::all();
    return view('pages.peta', compact('features', 'categories'));
})->name('peta');

Route::get('/publikasi', function () {
    $news = NewsArticle::latest('published_at')->get();

    return view('pages.publikasi', compact('news'));
})->name('publikasi');

Route::get('/berita/{slug}', function ($slug) {
    $berita = NewsArticle::where('slug', $slug)->firstOrFail();
    $recommendations = NewsArticle::where('id', '!=', $berita->id)->latest('published_at')->take(4)->get();

    return view('pages.berita-show', compact('berita', 'recommendations'));
})->name('berita.show');

Route::get('/wisata/{slug}', function ($slug) {
    $wisata = LocationSite::where('slug', $slug)->firstOrFail();
    $recommendations = LocationSite::where('id', '!=', $wisata->id)->where('status', 'active')->latest()->take(4)->get();

    return view('pages.wisata-show', compact('wisata', 'recommendations'));
})->name('wisata.show');

Route::get('/qr/{qr_code}', [LocationSiteController::class, 'qrRedirect'])->name('qr.redirect');
