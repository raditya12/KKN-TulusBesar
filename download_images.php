<?php

$img_dir = __DIR__.'/public/images/dummy/';
if (! is_dir($img_dir)) {
    mkdir($img_dir, 0777, true);
}

// List of unique Unsplash URLs used in the project
$urls = [
    'hero' => 'https://images.unsplash.com/photo-1552554792-5eb329a2862b?q=80&w=2000&auto=format&fit=crop',
    'profil' => 'https://images.unsplash.com/photo-1582572714421-4824888806fb?q=80&w=1000&auto=format&fit=crop',
    'webgis' => 'https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1500&auto=format&fit=crop',
    'news1' => 'https://images.unsplash.com/photo-1596422846543-74c6eb0809ab?q=80&w=800&auto=format&fit=crop',
    'news2' => 'https://images.unsplash.com/photo-1604928141064-207cea6f5722?q=80&w=800&auto=format&fit=crop',
    'news3' => 'https://images.unsplash.com/photo-1542621334-a2542d773e0b?q=80&w=800&auto=format&fit=crop',
    'wisata_hero' => 'https://images.unsplash.com/photo-1577717903315-1691ae25ab3f?q=80&w=2000&auto=format&fit=crop',
    'wisata1' => 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?q=80&w=800&auto=format&fit=crop',
    'wisata2' => 'https://images.unsplash.com/photo-1629851608678-cbfcc9689fcc?q=80&w=800&auto=format&fit=crop',
    'wisata3' => 'https://images.unsplash.com/photo-1533613220915-609f661a6fe1?q=80&w=800&auto=format&fit=crop',
    'tradisi1' => 'https://images.unsplash.com/photo-1548013146-72479768bada?q=80&w=1000&auto=format&fit=crop',
    'tradisi2' => 'https://images.unsplash.com/photo-1511219983944-118bdcc4944d?q=80&w=1000&auto=format&fit=crop',
    'tradisi3' => 'https://images.unsplash.com/photo-1574676435345-3db5fbcf6e83?q=80&w=1000&auto=format&fit=crop',
    'umkm1' => 'https://images.unsplash.com/photo-1628187834571-0815eb00c735?q=80&w=400&auto=format&fit=crop',
    'kades' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=200&auto=format&fit=crop',
];

echo "Downloading images...\n";
foreach ($urls as $name => $url) {
    $file_path = $img_dir.$name.'.jpg';
    if (! file_exists($file_path)) {
        // use curl for better reliability
        $ch = curl_init($url);
        $fp = fopen($file_path, 'wb');
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
        echo "Downloaded $name.jpg\n";
    } else {
        echo "Exists $name.jpg\n";
    }
}

// Now replace in all blade files
$views_dir = __DIR__.'/resources/views/pages/';
$files = glob($views_dir.'*.blade.php');

foreach ($files as $file) {
    $content = file_get_contents($file);

    foreach ($urls as $name => $url) {
        // Convert to asset() syntax
        $asset_url = "{{ asset('images/dummy/$name.jpg') }}";

        // Escape special chars in regex
        $safe_url = preg_quote($url, '/');

        $content = preg_replace('/'.$safe_url.'/', $asset_url, $content);
    }

    file_put_contents($file, $content);
    echo 'Updated links in '.basename($file)."\n";
}
