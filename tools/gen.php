<?php
die('Deprecated.');
// @TODO: Remove

if ($argc < 2) die("Usage: " . $argv[0] . " <stc> <?dst>\n");
$src = $argv[1];
$dst = null;
if ($argc > 2)
  $dst = $argv[2];

// The order is important, longest first
$words = [
  // Create Deco
  [
    'Catwalk' => 'Futóhíd',
    'Stairs' => 'Lépcsők',
    'Stair' => 'Lépcső',
    'Train Hull' => 'Vonattest',
    'Mesh Fence' => 'Hálós kerítés',
    'Lemez Fém' => 'Fémlemez',
    'Lemez Slab' => 'Lemezlap',
    'Lemez Lépcsők' => 'Lemezlépcsők',
    'Decal' => 'Matrica',
    'Placard' => 'Plakát',
    'Cage' => 'Kalitkás',
    'Wall' => 'Fal',
    'Slab' => 'Lap',
    'Cast Vas' => 'Öntöttvas',
    'Support' => 'Tartó',
    'Coinstack' => 'Érmehalom',
    'Coin' => 'Érme',
    'Scarlet' => 'Skarlát',
    'Dusk Tégla' => 'Alkonyattégla',
  ],
];

$fh = fopen($src, 'r');
if ($fh === false) die("Cannot open file: $src\n");
if ($dst !== null) $fh2 = fopen($dst, 'w');

while (($line = fgets($fh)) !== false) {
  $line = trim($line);
  // Skip empty lines
  if (empty($line)) continue;
  // Replace words
  foreach($words as $wordlist)
    foreach($wordlist as $key => $value)
      $line = str_replace($key, $value, $line);
  // Fix mixed case words after replacements
  $line = preg_replace_callback('/\b[A-Z][a-z]+\b/', function($m) {
    return ucfirst(strtolower($m[0]));
  }, $line);
  if ($dst === null) // If no destination file, print to stdout
    echo "$line\n";
  else fwrite($fh2, "$line\n"); // Write to file
}
fclose($fh);
if ($dst !== null) fclose($fh2);
