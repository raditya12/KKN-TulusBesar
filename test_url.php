<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CulturalSite;

$site = CulturalSite::first();
if ($site) {
    echo "URL from Storage::disk('public')->url():\n";
    echo \Illuminate\Support\Facades\Storage::disk('public')->url($site->image_path) . "\n\n";

    echo "URL from asset('storage/'):\n";
    echo asset('storage/' . $site->image_path) . "\n\n";
}
