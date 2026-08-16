<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CulturalSite;

$site = CulturalSite::first();
if ($site) {
    echo "Site image_path accessor output:\n";
    var_dump($site->image_path);
    echo "Site images accessor output:\n";
    var_dump($site->images);
}
