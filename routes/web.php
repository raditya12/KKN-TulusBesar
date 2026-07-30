<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/profil', 'pages.profil')->name('profil');
Route::view('/wisata', 'pages.wisata')->name('wisata');
Route::get('/peta', function () {
    $features = \App\Models\GisFeature::all();
    return view('pages.peta', compact('features'));
})->name('peta');
Route::view('/publikasi', 'pages.publikasi')->name('publikasi');
Route::view('/umkm', 'pages.umkm')->name('umkm');
