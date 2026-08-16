<?php

$dir = __DIR__ . '/resources/views/pages/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    // Replace \Illuminate\Support\Facades\Storage::disk('public')->url($var) with asset('storage/'.$var)
    // The regex needs to handle the variable name inside the url() function.
    $newContent = preg_replace_callback(
        '/\\\\Illuminate\\\\Support\\\\Facades\\\\Storage::disk\(\'public\'\)->url\(([^)]+)\)/',
        function ($matches) {
            $var = trim($matches[1]);
            // If the variable is something like $s->image_path, we wrap it
            return "asset('storage/' . " . $var . ")";
        },
        $content
    );
    
    if ($content !== $newContent) {
        file_put_contents($file, $newContent);
        echo "Updated $file\n";
    }
}
