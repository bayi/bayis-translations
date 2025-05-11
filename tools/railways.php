<?php
include_once 'lib/index.php';

$pass1 = [
  'train casing' => 'vonatburkolat',
  'train station' => 'vasútállomás',
  'locometal' => 'mozdonyfém',
  'boiler' => 'kazán',
  'boilers' => 'kazánok',
  'smokebox' => 'füstkamra',
  'fuel tank' => 'üzemanyagtartály',
  'vent' => 'szellőző',
  'monorail' => 'nyeregvasút',
  'bogey' => 'csille',
  'copycat' => 'imitátor',
  'handcar' => 'kézikocsi',
  'coupler' => 'kapcsoló',
  'couplers' => 'kapcsolók',
  'semaphore' => 'szemafor',
  'axle' => 'tengely',
  'smokestack' => 'kémény',
  'coalburner' => 'szénégető',
  'radiator' => 'hűtő',
  'fan' => 'ventilátor',
  'track buffer' => 'sínpuffer',
  'train track' => 'vasúti sín',
  'headstock' => 'fejrész',
  'headstocks' => 'fejrészek',
  'pillars' => 'pillérek',
  'train' => 'vonat',
  'conductor' => 'kalauz',
  'cap' => 'sapka',
  'caps' => 'sapkák',
  'string' => 'fonál',
  'pole' => 'oszlop',
  'poles' => 'oszlopok',
];

$pass2 = [
  'wrapped' => 'burkolt',
  'riveted' => 'szegecselt',
  'slashed' => 'vágott',
  'generic' => 'általános',
  'single' => 'egyszeres',
  'double' => 'dupla',
  'flat' => 'lapos',
  'invisible' => 'láthatatlan',
  'medium' => 'közepes',
  'wide' => 'széles',
  'narrow' => 'keskeny',
  'plated' => 'lemezes',
  'small' => 'kis',
  'dead' => 'halott',
  'fir' => 'erdei fenyő',
  'magic' => 'varázslatos',
  'willow' => 'fűz',
  'dusk' => 'alkony',
  'mahogany' => 'mahagóni',
  'palm' => 'pálma',
  'pine' => 'fenyő',
  'buffer' => 'puffer',
  'phantom' => 'fantom',
  'stack' => 'halom',
];

$fixes = [
];

$data = processFile(
  '../originals/railways/en_us.json',
  [
    ...$dictionary,
    $pass1,
    $pass2,
    $fixes,
  ]
);

$file = $argc > 1 ? $argv[1] ?? 'railways.json' : 'railways.json';
saveAs($data, $file, true);
