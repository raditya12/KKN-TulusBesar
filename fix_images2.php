<?php

$dir = __DIR__ . '/resources/views/pages/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Replace asset('storage/' . $var) with url('/download-file?path=' . $var)
    // The regex needs to handle the concatenation properly.
    // Example: asset('storage/' . $site->image_path) -> url('/download-file?path=' . $site->image_path)
    $newContent = preg_replace(
        '/asset\(\'storage\/\'\s*\.\s*([^)]+)\)/',
        "url('/download-file?path=' . $1)",
        $content
    );
    
    // Also check livewire components if needed, but earlier we only did resources/views/pages/*.blade.php
    
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
