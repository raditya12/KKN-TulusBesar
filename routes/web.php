<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $umkms = \App\Models\Umkm::whereNotNull('latitude')->whereNotNull('longitude')->get();
    $culturalSites = \App\Models\CulturalSite::whereNotNull('latitude')->whereNotNull('longitude')->get();
    $gisFeatures = \App\Models\GisFeature::whereNotNull('latitude')->whereNotNull('longitude')->get();
    
    return view('pages.home', compact('umkms', 'culturalSites', 'gisFeatures'));
})->name('home');
Route::view('/profil', 'pages.profil')->name('profil');
Route::view('/wisata', 'pages.wisata')->name('wisata');
Route::get('/peta', [\App\Http\Controllers\WebGisController::class, 'index'])->name('peta');
Route::get('/tutorials', [\App\Http\Controllers\TutorialController::class, 'index'])->name('tutorials.index');
Route::get('/tutorials/{slug}', [\App\Http\Controllers\TutorialController::class, 'show'])->name('tutorials.show');

Route::view('/publikasi', 'pages.publikasi')->name('publikasi');
Route::view('/umkm', 'pages.umkm')->name('umkm');
