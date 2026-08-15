<?php
$files = glob('c:/laragon/www/tulusbesar/KKN-TulusBesar/resources/views/pages/*.blade.php');
foreach($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace("asset('storage/' . ", "\Illuminate\Support\Facades\Storage::disk('public')->url(", $content);
    file_put_contents($file, $content);
}
echo "Replaced in " . count($files) . " files.\n";
