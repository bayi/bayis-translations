<?php
include_once 'lib/index.php';

$pass1 = [
  'crooks' => 'kampók',
  'hammers' => 'kalapácsok',
  'pebbles' => 'kavicsok',
  'meshes' => 'hálók',
  'sands' => 'homokok',
  'pottery shert' => 'cserépszilánk',
  'armor trim' => 'páncéldísz',
  'spores' => 'spórák',
  'golden' => 'arany',
  'fluid mixing' => 'folyadékkeverés',
  'chance:' => 'Esély:',
  'infested leaves' => 'fertőzött levelek',
  'láva bucket' => 'lávásvödör',
  'milk bucket' => 'tejesvödör',
  'witch water bucket' => 'boszorkányvizesvödör',
  'witch víz bucket' => 'boszorkányvizesvödör',
];

$pass2 = [
  'sieve' => 'szita',
  'crucible' => 'olvasztótégely',
  'hammer' => 'kalapács',
  'pebble' => 'kavics',
  'mesh' => 'háló',
  'silkworm' => 'selyemhernyó',
  'dust' => 'por',
  'crushed' => 'szétzúzott',
  'crystallized' => 'kristályosodott',
  'dusk' => 'alkony',
  'fir' => 'fenyő',
  'magic' => 'varázs',
  'palm' => 'pálmafa',
  'witch' => 'boszorkány',
  'crook' => 'kampó',
  'bone' => 'csont',
  'flint' => 'kovakő',
  'chunk' => 'darab',
  'seeds' => 'mag',
  'core' => 'mag',
  'ore' => 'érc',
  'wood' => 'fa',
  'wooden' => 'fa',
  'mechanical' => 'mechanikus',
  'chippings' => 'forgács',
  'watering can' => 'öntözőkanna',
  'silver' => 'ezüst',
  'random' => 'véletlenszerű',
  'cooked' => 'főtt',
  'gold' => 'arany',
  'dead' => 'halott',
  'mixing' => 'keverés',
  'willow' => 'fűzfa',
  'skyroot' => 'égfa',
  'porcelain' => 'porcelán',
  'maple' => 'juharfa',
  'mahagony' => 'mahagóni',
  'jacaranda' => 'jakarandafa',
  'unfired' => 'nyers',
  'nickel' => 'nikkel',
  'osmium' => 'ozmium',
  'platinum' => 'platina',
  'magnesium' => 'magnézium',
  'lithium' => 'lítium',
  'lead' => 'ólom',
  'cobalt' => 'kobalt',
];

$pass3 = [
  'compressed' => 'tömörített',
  'érc darab' => 'ércdarab',
  'víz bucket' => 'vizesvödör',
  'bucket' => 'vödör',
  'always' => 'mindig',
  'energy' => 'energia',
  'powered' => 'meghajtott',
  'unpowered' => 'meghajtás nélküli',
];

$grammar = [
  'agyag ball' => 'agyaggolyó',
  'boszorkány víz' => 'boszorkányvíz',
];

$fixes = [
];

$data = processFile(
  '../originals/exdeorum/en_us.json',
  [
    ...$dictionary,
    $pass1,
    $pass2,
    $pass3,
    $grammar,
    $fixes,
  ]
);

$file = $argc > 1 ? $argv[1] ?? 'exdeorum.json' : 'exdeorum.json';
saveAs($data, $file, true);
