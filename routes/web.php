<?php

use App\Http\Controllers\TourController;
use App\Models\ActivityPhoto;
use App\Models\CulturalSite;
use App\Models\GisFeature;
use App\Models\NewsArticle;
use App\Models\Umkm;
use App\Models\VillageOfficial;
use App\Models\VillageProfile;
use Illuminate\Support\Facades\Route;

Route::post('/custom-logout', function (\Illuminate\Http\Request $request) {
    auth()->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/admin/login');
})->name('custom.logout');

Route::get('/', function () {
    $news = NewsArticle::latest('published_at')->take(3)->get();
    $umkms = Umkm::latest()->take(3)->get();
    $profile = VillageProfile::first();

    // Kumpulkan semua gambar dari semua konten untuk slideshow (hanya select image_path)
    $allImages = collect()
        ->merge(
            NewsArticle::whereNotNull('image_path')->latest('published_at')->pluck('image_path')
                ->map(fn ($path) => asset('storage/'.$path))
        )
        ->merge(
            Umkm::whereNotNull('image_path')->latest()->pluck('image_path')
                ->map(fn ($path) => asset('storage/'.$path))
        )
        ->merge(
            CulturalSite::whereNotNull('image_path')->where('status', 'active')->latest()->pluck('image_path')
                ->map(fn ($path) => asset('storage/'.$path))
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
    $activities = ActivityPhoto::latest()->get();

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
    $news = NewsArticle::latest('published_at')->get();

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
    $wisata = CulturalSite::where('slug', $slug)->where('status', 'active')->firstOrFail();
    $recommendations = CulturalSite::where('id', '!=', $wisata->id)->where('status', 'active')->latest()->take(4)->get();

    return view('pages.wisata-show', compact('wisata', 'recommendations'));
})->name('wisata.show');

// Tour status routes — protected by auth middleware
Route::middleware('auth')->group(function () {
    Route::post('/admin/tour/complete', [TourController::class, 'complete'])->name('tour.complete');
    Route::post('/admin/tour/reset', [TourController::class, 'reset'])->name('tour.reset');
});

// Fallback jika symlink di disable oleh Jagoan Hosting
Route::get('/storage/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath);
})->where('path', '.*');

Route::get('/fix-symlink-real', function () {
    $target = storage_path('app/public');
    $link = '/home/tulusbe1/public_html/storage';
    
    if (file_exists($link)) {
        // Jika berupa symlink lama atau file, hapus dulu
        if (is_link($link) || !is_dir($link)) {
            unlink($link);
        } else {
            return 'GAGAL: Hapus dulu folder "storage" (yang berisi folder-folder) di dalam public_html melalui File Manager.';
        }
    }
    
    symlink($target, $link);
    return 'BERHASIL: Symlink berhasil dibuat langsung di public_html/storage!';
});

Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Symlink berhasil dibuat! Silakan hapus route ini.';
});

Route::get('/debug-storage', function () {
    $results = [];
    $results['storage_path'] = storage_path('app/public');
    $results['public_path'] = public_path('storage');
    $results['disk_root'] = config('filesystems.disks.public.root');
    $results['put_test'] = \Illuminate\Support\Facades\Storage::disk('public')->put('village-documents/test.txt', 'test');
    $results['exists_test'] = \Illuminate\Support\Facades\Storage::disk('public')->exists('village-documents/test.txt');
    $results['files_in_village_docs'] = \Illuminate\Support\Facades\Storage::disk('public')->files('village-documents');
    return response()->json($results);
});

Route::get('/fix-storage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Symlink berhasil dibuat! Silakan hapus route ini.';
});