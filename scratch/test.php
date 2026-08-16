<?php
// Simulate Filament's FileUpload reordered array
$stateFromFilament = [
    'uuid2' => 'path2.jpg',
    'uuid1' => 'path1.jpg',
];

$arrayValues = array_values($stateFromFilament);
$json = json_encode($arrayValues);

echo "Filament State:\n";
print_r($stateFromFilament);

echo "\nArray Values:\n";
print_r($arrayValues);

echo "\nJSON:\n";
echo $json . "\n";
