<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\CulturalSite;

$site = CulturalSite::first();
if (!$site) {
    echo "No site found.\n";
    exit;
}

$oldImages = $site->images;
echo "Old Images:\n";
print_r($oldImages);

// Reorder images
if (count($oldImages) > 1) {
    $newImages = array_reverse($oldImages);
    $site->images = $newImages;
    echo "New Images before save:\n";
    print_r($site->images);
    
    echo "Is Dirty? " . ($site->isDirty() ? 'Yes' : 'No') . "\n";
    echo "Dirty Attributes:\n";
    print_r($site->getDirty());
    
    $site->save();
    echo "Saved.\n";
    
    $site->refresh();
    echo "After refresh:\n";
    print_r($site->images);
} else {
    echo "Not enough images to test reorder. Creating fake images...\n";
    $site->images = ['dummy1.jpg', 'dummy2.jpg'];
    $site->save();
    echo "Created fake images. Run again to test reorder.\n";
}
