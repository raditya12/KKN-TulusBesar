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

    return view('pages.home', compact('news', 'umkms', 'profile'));
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

Route::view('/peta', 'pages.peta')->name('peta');

Route::get('/publikasi', function () {
    $news = NewsArticle::latest('published_at')->get();

    return view('pages.publikasi', compact('news'));
})->name('publikasi');

Route::get('/umkm', function () {
    $umkms = Umkm::latest()->get();

    return view('pages.umkm', compact('umkms'));
})->name('umkm');
