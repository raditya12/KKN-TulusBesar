<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'pages.home')->name('home');
Route::view('/profil', 'pages.profil')->name('profil');
Route::view('/wisata', 'pages.wisata')->name('wisata');
Route::view('/peta', 'pages.peta')->name('peta');
Route::view('/publikasi', 'pages.publikasi')->name('publikasi');
Route::view('/umkm', 'pages.umkm')->name('umkm');
