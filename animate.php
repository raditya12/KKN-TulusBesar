<?php
$dir = __DIR__ . '/resources/views/pages/';
$files = glob($dir . '*.blade.php');

foreach ($files as $file) {
    if (basename($file) === 'peta.blade.php') continue;
    $content = file_get_contents($file);
    
    // Add animations to max-w-screen-xl wrappers
    $pattern = '/class="(max-w-screen-xl mx-auto px-[a-z0-9\-\:]+container-margin[^"]*)"/';
    $replacement = 'class="$1 transition-all duration-1000 ease-out transform" x-data="{ shown: false }" x-intersect.once="shown = true" :class="shown ? \'opacity-100 translate-y-0\' : \'opacity-0 translate-y-12\'"';
    
    // Avoid double-applying if already applied
    if (strpos($content, 'x-intersect.once="shown = true"') === false) {
        $content = preg_replace($pattern, $replacement, $content);
    }
    
    // Add hero animation specifically for home page hero
    $heroPattern = '/class="(relative z-10 text-center px-[a-z0-9\-\:]+container-margin max-w-\[56rem\] mx-auto flex flex-col items-center gap-lg)"/';
    $heroReplacement = 'class="$1 transition-all duration-1000 delay-300 ease-out transform" x-data="{ shown: false }" x-init="setTimeout(() => shown = true, 100)" :class="shown ? \'opacity-100 translate-y-0\' : \'opacity-0 translate-y-8\'"';
    if (strpos($content, 'x-init="setTimeout(') === false) {
        $content = preg_replace($heroPattern, $heroReplacement, $content);
    }
    
    file_put_contents($file, $content);
    echo "Processed " . basename($file) . "\n";
}
?>
