<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CulturalSite;
use App\Models\NewsArticle;
use App\Models\Umkm;

echo "=== CulturalSite ===\n";
$sites = CulturalSite::all();
foreach ($sites as $s) {
    $raw = $s->getAttributes()['image_path'] ?? 'null';
    echo "ID: {$s->id} | Name: {$s->name}\n";
    echo "  RAW image_path in DB: {$raw}\n";
    echo "  image_path accessor: " . ($s->image_path ?? 'null') . "\n";
    echo "  images accessor: " . json_encode($s->images) . "\n\n";
}

echo "=== NewsArticle ===\n";
$articles = NewsArticle::take(3)->get();
foreach ($articles as $a) {
    $raw = $a->getAttributes()['image_path'] ?? 'null';
    echo "ID: {$a->id} | Title: {$a->title}\n";
    echo "  RAW image_path in DB: {$raw}\n";
    echo "  image_path accessor: " . ($a->image_path ?? 'null') . "\n";
    echo "  images accessor: " . json_encode($a->images) . "\n\n";
}

echo "=== Umkm ===\n";
$umkms = Umkm::take(3)->get();
foreach ($umkms as $u) {
    $raw = $u->getAttributes()['image_path'] ?? 'null';
    echo "ID: {$u->id} | Name: {$u->name}\n";
    echo "  RAW image_path in DB: {$raw}\n";
    echo "  image_path accessor: " . ($u->image_path ?? 'null') . "\n";
    echo "  images accessor: " . json_encode($u->images) . "\n\n";
}
